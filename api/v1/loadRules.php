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


echo "<p>Adding Rule TEST</p>"; $conn->addRule("TEST", "This is a test rule");
foreach ($rChaos as $code => $text){ echo "<p>Adding Rule $code</p>"; $conn->addRule($code, $text); }
foreach ($rDurgs as $code => $text){ echo "<p>Adding Rule $code</p>"; $conn->addRule($code, $text); }
foreach ($rEnchant as $code => $text){ echo "<p>Adding Rule $code</p>"; $conn->addRule($code, $text); }
foreach ($rPersona as $code => $text){ echo "<p>Adding Rule $code</p>"; $conn->addRule($code, $text); }
foreach ($rPunishment as $code => $text){ echo "<p>Adding Rule $code</p>"; $conn->addRule($code, $text); }
foreach ($rWacky as $code => $text){ echo "<p>Adding Rule $code</p>"; $conn->addRule($code, $text); }
