<?php

class Reciter
{
	private $lyricLines;
	private $totalLyricLines;

	public function __construct($lyric)
	{
		$this->lyricLines = explode("\n", $lyric);
		$this->totalLyricLines = count($this->lyricLines);
	}

	public function doRecite($input)
	{
		try {
			$input = $this->validateInput($input);
			$unrecitedLines = $this->totalLyricLines - $input;
			$recitedLines = array_slice($this->lyricLines, $unrecitedLines);

			return implode(' ', $recitedLines);
		} catch (Exception $ex) {
			return $ex->getMessage();
		}
	}

	public function doRandomRecite()
	{
		$minRangeLine = 0; // An array starting index
		$maxRangeLine = $this->totalLyricLines - 1; // Minus 1 because the index was starting with 0

		return $this->doRecite(rand($minRangeLine, $maxRangeLine) + 1); // Randomize the input number
	}

	public function doReciteSubject($input)
	{
		try {
			$input = $this->validateInput($input);
			$unrecitedLines = $this->totalLyricLines - $input;
			$recitedLines = array_slice($this->lyricLines, $unrecitedLines);

			$recitedSubjects = [];
			foreach ($recitedLines as $recitedLine) {
				$recitedSubjects[] = $this->getSubject($recitedLine);
			}

			return "This is " . $this->combineSubjets($recitedSubjects);
		} catch (Exception $ex) {
			return $ex->getMessage();
		}
	}

	public function doRandomReciteSubjects()
	{
		$minRangeLine = 0; // An array starting index
		$maxRangeLine = $this->totalLyricLines - 1; // Minus 1 because the index was starting with 0

		return $this->doReciteSubject(rand($minRangeLine, $maxRangeLine) + 1); // Randomize the input number between 0 to 11
	}

	private function getSubject($lineText)
	{
		preg_match('/^((\w+\s\w+)(((\sand)\s(\w+\s\w+))?)+)\s/', $lineText, $matches); // Perform simple regex to extract the subject

		return trim($matches[0]);
	}

	private function combineSubjets($subjects)
	{
		if(count($subjects) > 1) {
			$lastPart = array_pop($subjects);
			$firstPart = implode(', ', $subjects);
			return implode(' and ', [$firstPart, $lastPart]);
		} else {
			return $subjects[0];
		}
	}

	private function validateInput($input)
	{
		if ($input < 1) {
			throw new Exception("ERROR: Number smaller than 1 is not allowed.");
		}

		if ($input > $this->totalLyricLines) {
			throw new Exception("ERROR: Number greater than 12 is not allowed.");
		}

		return $input;
	}
}
