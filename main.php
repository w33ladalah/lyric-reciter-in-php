<?php

require_once 'Reciter.php';

$lyrics = <<<EOD
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
$inputNum = intval($argv[1] ?? 1);
$recite = new Reciter($lyrics);

echo "PHASE 1".PHP_EOL;
echo "Recite " . $inputNum . " => " . $recite->doRecite($inputNum);
echo PHP_EOL . PHP_EOL . "==========================================================================================" . PHP_EOL . PHP_EOL;

echo "PHASE 2" . PHP_EOL;
echo "A. Random Recite => " . $recite->doRandomRecite() . PHP_EOL . PHP_EOL;
echo "B. Subject Recite " . $inputNum . " => " . $recite->doReciteSubject($inputNum) . PHP_EOL . PHP_EOL;
echo "C. Random Subject Recite => " . $recite->doRandomReciteSubjects() . PHP_EOL;
