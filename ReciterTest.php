<?php

require 'Reciter.php';

use PHPUnit\Framework\TestCase as TestCase;

class ReciterTest extends TestCase
{
	private $reciter;
	private $lyricLines;
	private $totalLyricLines;
	private $allRecitesText;
	private $allSubjectsText;

	protected function setUp(): void
	{
		$lyricText = <<<EOD
the horse and the hound and the horn that belonged to
the farmer sowing his corn that kept
the rooster that crowed in the morn that woke
the priest all shaven and shorn that married
the man all tattered and torn that kissed
the maiden all forlorn that milked
the cow with the crumpled horn that tossed
the dog that worried
the cat that killed
the rat that ate
the malt that lay in
the house that Jack built
EOD;

		$this->lyricLines = explode("\n", $lyricText);
		$this->totalLyricLines = count($this->lyricLines);
		$this->reciter = new Reciter($lyricText);
		$this->allRecitesText = [
			'the house that Jack built',
			'the malt that lay in the house that Jack built',
			'the rat that ate the malt that lay in the house that Jack built',
			'the cat that killed the rat that ate the malt that lay in the house that Jack built',
			'the dog that worried the cat that killed the rat that ate the malt that lay in the house that Jack built',
			'the cow with the crumpled horn that tossed the dog that worried the cat that killed the rat that ate the malt that lay in the house that Jack built',
			'the maiden all forlorn that milked the cow with the crumpled horn that tossed the dog that worried the cat that killed the rat that ate the malt that lay in the house that Jack built',
			'the man all tattered and torn that kissed the maiden all forlorn that milked the cow with the crumpled horn that tossed the dog that worried the cat that killed the rat that ate the malt that lay in the house that Jack built',
			'the priest all shaven and shorn that married the man all tattered and torn that kissed the maiden all forlorn that milked the cow with the crumpled horn that tossed the dog that worried the cat that killed the rat that ate the malt that lay in the house that Jack built',
			'the rooster that crowed in the morn that woke the priest all shaven and shorn that married the man all tattered and torn that kissed the maiden all forlorn that milked the cow with the crumpled horn that tossed the dog that worried the cat that killed the rat that ate the malt that lay in the house that Jack built',
			'the farmer sowing his corn that kept the rooster that crowed in the morn that woke the priest all shaven and shorn that married the man all tattered and torn that kissed the maiden all forlorn that milked the cow with the crumpled horn that tossed the dog that worried the cat that killed the rat that ate the malt that lay in the house that Jack built',
			'the horse and the hound and the horn that belonged to the farmer sowing his corn that kept the rooster that crowed in the morn that woke the priest all shaven and shorn that married the man all tattered and torn that kissed the maiden all forlorn that milked the cow with the crumpled horn that tossed the dog that worried the cat that killed the rat that ate the malt that lay in the house that Jack built',
		];

		$this->allSubjectsText = [
			'This is the house',
			'This is the malt and the house',
			'This is the rat, the malt and the house',
			'This is the cat, the rat, the malt and the house',
			'This is the dog, the cat, the rat, the malt and the house',
			'This is the cow, the dog, the cat, the rat, the malt and the house',
			'This is the maiden, the cow, the dog, the cat, the rat, the malt and the house',
			'This is the man, the maiden, the cow, the dog, the cat, the rat, the malt and the house',
			'This is the priest, the man, the maiden, the cow, the dog, the cat, the rat, the malt and the house',
			'This is the rooster, the priest, the man, the maiden, the cow, the dog, the cat, the rat, the malt and the house',
			'This is the farmer, the rooster, the priest, the man, the maiden, the cow, the dog, the cat, the rat, the malt and the house',
			'This is the horse and the hound and the horn, the farmer, the rooster, the priest, the man, the maiden, the cow, the dog, the cat, the rat, the malt and the house'
		];
	}

	protected function tearDown(): void
	{
		$this->reciter = NULL;
	}

	/**
	 * This method is used for testing private method purpose only.
	 */
	public function invokeMethod(&$object, $methodName, array $parameters = array())
	{
		$reflection = new \ReflectionClass(get_class($object));
		$method = $reflection->getMethod($methodName);
		$method->setAccessible(true);

		return $method->invokeArgs($object, $parameters);
	}

	public function testDoRecite1()
	{
		$input = 1;
		$result = $this->reciter->doRecite($input);
		$this->assertEquals($this->allRecitesText[$input - 1], $result);
	}

	public function testDoRecite2()
	{
		$input = 2;
		$result = $this->reciter->doRecite($input);
		$this->assertEquals($this->allRecitesText[$input - 1], $result);
	}

	public function testDoRecite3()
	{
		$input = 3;
		$result = $this->reciter->doRecite($input);
		$this->assertEquals($this->allRecitesText[$input - 1], $result);
	}

	public function testDoRecite4()
	{
		$input = 4;
		$result = $this->reciter->doRecite($input);
		$this->assertEquals($this->allRecitesText[$input - 1], $result);
	}

	public function testDoRecite5()
	{
		$input = 5;
		$result = $this->reciter->doRecite($input);
		$this->assertEquals($this->allRecitesText[$input - 1], $result);
	}

	public function testDoRecite12()
	{
		$input = 12;
		$result = $this->reciter->doRecite($input);

		$this->assertEquals($this->allRecitesText[$input - 1], $result);
	}

	public function testDoRandomRecite()
	{
		$result = $this->reciter->doRandomRecite();
		$this->assertContains($result, $this->allRecitesText);
	}

	public function testDoReciteSubject()
	{
		$input = 1;
		$result = $this->reciter->doReciteSubject($input);
		$this->assertEquals($this->allSubjectsText[$input - 1], $result);
	}

	public function testDoRandomReciteSubject()
	{
		$result = $this->reciter->doRandomReciteSubjects();
		$this->assertContains($result, $this->allSubjectsText);
	}

	public function testGetSubject()
	{
		$input = 12;
		$lyricLine = $this->allRecitesText[$input - 1];
		$result = "This is " . $this->invokeMethod($this->reciter, 'getSubject', [$lyricLine]);
		$this->assertEquals('This is the horse and the hound and the horn', $result);
	}

	public function testCombineSubjetsManySubjects()
	{
		$input = 2;
		$unrecitedLines = $this->totalLyricLines - $input;
		$recitedLines = array_slice($this->lyricLines, $unrecitedLines);

		$recitedSubjects = [];
		foreach ($recitedLines as $recitedLine) {
			$recitedSubjects[] = $this->invokeMethod($this->reciter, 'getSubject', [$recitedLine]);
		}

		$result = "This is " . $this->invokeMethod($this->reciter, 'combineSubjets', [$recitedSubjects]);
		$this->assertEquals($this->allSubjectsText[$input - 1], $result);
	}

	public function testCombineSubjetsOneSubject()
	{
		$input = 12;
		$unrecitedLines = $this->totalLyricLines - $input;
		$recitedLines = array_slice($this->lyricLines, $unrecitedLines);

		$recitedSubjects = [];
		foreach ($recitedLines as $recitedLine) {
			$recitedSubjects[] = $this->invokeMethod($this->reciter, 'getSubject', [$recitedLine]);
		}

		$result = "This is " . $this->invokeMethod($this->reciter, 'combineSubjets', [$recitedSubjects]);
		$this->assertEquals($this->allSubjectsText[$input - 1], $result);
	}

	public function testValidateInputCorrectInput()
	{
		$randomInput = rand(1, 12);
		$result = $this->invokeMethod($this->reciter, 'validateInput', [$randomInput]);
		$this->assertContains($result, range(1, 12));
	}

	public function testValidateInputSmallerThan1()
	{
		$this->expectException(Exception::class);
		$this->expectExceptionMessage("ERROR: Number smaller than 1 is not allowed.");

		$input = 0;
		$this->invokeMethod($this->reciter, 'validateInput', [$input]);
	}

	public function testValidateInputGreaterThan12()
	{
		$this->expectException(Exception::class);
		$this->expectExceptionMessage("ERROR: Number greater than 12 is not allowed.");

		$input = 11;
		$this->invokeMethod($this->reciter, 'validateInput', [$input]);
	}
}
