<?php

//Bring in core include file
include_once '../coreIncludes.php';

//Create DB connection
$conn = New ChaosDB();


$rChaos         = loadJSONFile('../data/rulesets/chaos.json');
$rDurgs         = loadJSONFile('../data/rulesets/durgsLand.json');
$rEnchant       = loadJSONFile('../data/rulesets/enchantWorldLand.json');
$rPersona       = loadJSONFile('../data/rulesets/personaLand.json');
$rPunishment    = loadJSONFile('../data/rulesets/punishmentLand.json');
$rWacky         = loadJSONFile('../data/rulesets/wackyLand.json');


//Add a test rule
echo $conn->addRule("TEST", "This is a test rule");


