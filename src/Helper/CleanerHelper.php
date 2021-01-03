<?php

namespace Risendy\ChessPgnParser\Helper;

class CleanerHelper {
	const HEADER_REGEX = '/^(\[((?:\r?\n)|.)*\])(?:\r?\n){2}/';
	const HEADER_KEY_REGEX = '/^\[([A-Z][A-Za-z]*)\s.*\]$/';
	const HEADER_VALUE_REGEX = '/^\[[A-Za-z]+\s"(.*)"\]$/';
	const COMMENTS_REGEX = '/(\{[^}]+\})+?/';
	const MOVE_VARIATIONS_REGEX = '/(\([^\(\)]+\))+?/';
	const MOVE_NUMBER_REGEX = '/\d+\.(\.\.)?/';
	const MOVE_INDICATOR_REGEX = '/\.\.\./';
	const ANNOTATION_GLYPHS_REGEX = '/\$\d+/';
	const MULTIPLE_SPACES_REGEX = '/\s+/';

	public function clearMoveStr($clearMoveStr, $comments = false) {
		if (!$comments) $clearMoveStr = $this->deleteComments($clearMoveStr);

		$clearMoveStr = $this->deleteMoveVariations($clearMoveStr);
		$clearMoveStr = $this->deleteMoveNumber($clearMoveStr);
		$clearMoveStr = $this->deleteAnnotationGlyphs($clearMoveStr);
		$clearMoveStr = $this->trimMoveStr($clearMoveStr);

		return $clearMoveStr;
	}

	public function trimArrayElements($array) {
		return array_map('trim', $array); 
	}

	public function removeEmptyArrayElements($array) {
		return array_filter($array);
	}

	public function deleteComments($moveText) {
		return preg_replace(self::COMMENTS_REGEX, '', $moveText);
	}

	public function deleteMoveVariations($moveText) {
		return preg_replace(self::MOVE_VARIATIONS_REGEX, '', $moveText);
	}

	public function deleteMoveNumber($moveText) {
		return preg_replace(self::MOVE_NUMBER_REGEX, '', $moveText);	
	}

	public function deleteAnnotationGlyphs($moveText) {
		return preg_replace(self::ANNOTATION_GLYPHS_REGEX, '', $moveText);	
	}

	public function deleteMultipleSpaces($moveText) {
		return preg_replace(self::MULTIPLE_SPACES_REGEX, '', $moveText);	
	}

	public function trimMoveStr($moveText) {
		$moveText = trim($moveText);

		return preg_replace(self::MULTIPLE_SPACES_REGEX, ' ', $moveText);
	}
}