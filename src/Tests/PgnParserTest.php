<?php
declare(strict_types=1);

namespace Risendy\ChessPgnParser\Tests;

use PHPUnit\Framework\TestCase;
use Risendy\ChessPgnParser\Service\ChessParser;

/**
 * @property Game game
 */
final class PgnParserTest extends TestCase
{
    const PGN2 = '[Event "Lets Play!"]
		[Site "Chess.com"]
		[Date "2018.12.04"]
		[Round "?"]
		[White "guilherme_1910"]
		[Black "bmbio"]
		[Result "0-1"]
		[TimeControl "1/259200:0"]

		1. e4 e6 2. d4 {test} d5 0-1';

    const PGN3 = '[Event "Lets Play!"]
		[Site "Chess.com"]
		[Date "2018.12.04"]
		[Round "?"]
		[White "guilherme_1910"]
		[Black "bmbio"]
		[Result "0-1"]
		[TimeControl "1/259200:0"]

		1. e4 e6 2. d4';

    const PGN3_json = '{"tags":{"Event":"Lets Play!","Site":"Chess.com","Date":"2018.12.04","Round":"?","White":"guilherme_1910","Black":"bmbio","Result":"0-1","TimeControl":"1\/259200:0"},"moves":[{"moveNumber":1,"white":"e4","black":"e6"},{"moveNumber":2,"white":"d4","black":null}]}';

    const PGN2_move_text = 'e4 e6 d4 d5 0-1';
    const PGN2_header_text = '[Event "Lets Play!"]
		[Site "Chess.com"]
		[Date "2018.12.04"]
		[Round "?"]
		[White "guilherme_1910"]
		[Black "bmbio"]
		[Result "0-1"]
		[TimeControl "1/259200:0"]';

    const PGN2_move_2_white = 'd4';
    const PGN2_move_2_white_comment = 'test';
    const PGN2_move_2_black = 'd5';
    const PGN2_tag_black_value = 'bmbio';
    const PGN2_first_move = 'e4';

    private $game;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->game = new ChessParser();
    }

    public function testPgnMoveTextFromPgn(): void
    {
        $this->game->parsePgn(self::PGN2);
        $movesString = $this->game->getMovesString();
        
        $this->assertEquals(self::PGN2_move_text, $movesString);
    }

    public function testPgnHeaderTextFromPgn(): void
    {
        $this->game->parsePgn(self::PGN2);
        $headerString = $this->game->getHeaderString();

        $this->assertEquals(self::PGN2_header_text, $headerString);
    }

    public function testPgnGetMoveWhite(): void
    {
        $this->game->parsePgn(self::PGN2);
        $move = $this->game->getMove(2, 'W');

        $this->assertEquals(self::PGN2_move_2_white, $move->getSan());
    }

    public function testPgnGetMoveBlack(): void
    {
        $this->game->parsePgn(self::PGN2);
        $move = $this->game->getMove(2, 'B');

        $this->assertEquals(self::PGN2_move_2_black, $move->getSan());
    }

    public function testPgnGetMoveComment() :void
    {
        $this->game->parsePgn(self::PGN2);
        $move = $this->game->getMove(2, 'W');

        $this->assertEquals(self::PGN2_move_2_white_comment, $move->getComment());   
    }

    public function testPgnGetTagValueByName(): void
    {
        $this->game->parsePgn(self::PGN2);
        $black = $this->game->getTagValueByName('Black');

        $this->assertEquals(self::PGN2_tag_black_value, $black);
    }

    public function testPgnGetFirstMove(): void
    {
        $this->game->parsePgn(self::PGN2);
        $firstMove = $this->game->getFirstMove();

        $this->assertEquals(self::PGN2_first_move, $firstMove);
    }

    public function testPgnJsonArray(): void
    {
        $this->game->parsePgn(self::PGN3);
        $jsonArray = $this->game->createJsonArray();

        $this->assertEquals(self::PGN3_json, $jsonArray);
    }

}