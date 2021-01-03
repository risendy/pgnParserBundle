<?php

namespace Risendy\ChessPgnParser;

use Risendy\ChessPgnParser\DependencyInjection\ChessParserExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class PgnChessParserBundle extends Bundle
{
    public function getContainerExtension()
    {
        if (null === $this->extension) {
            $this->extension = new ChessParserExtension();
        }
        return $this->extension;
    }
}