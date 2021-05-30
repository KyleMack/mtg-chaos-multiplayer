<?php

//Bring in core include file
include_once '../coreIncludes.php';

$T_PLAYERS     = "players";
$T_RULES       = "rules";
$T_ACTIVEGAMES = "active_games";
$T_GAMEPLAYERS = "game_players";
$T_GAMERULES   = "game_rules";

$rChaos         = loadJSONFile('../data/rulesets/chaos.json');
$rDurgs         = loadJSONFile('../data/rulesets/durgsLand.json');
$rEnchant       = loadJSONFile('../data/rulesets/enchantWorldLand.json');
$rPersona       = loadJSONFile('../data/rulesets/personaLand.json');
$rPunishment    = loadJSONFile('../data/rulesets/punishmentLand.json');
$rWacky         = loadJSONFile('../data/rulesets/wackyLand.json');

$conn = New DatabaseConn();
setDBAdmin($conn);

echo "CLEARING TABLES...<BR/>";

echo "<BR/>CLEARING RULES LIST...";
echo $conn->clearTable($T_GAMERULES);

echo "<BR/>CLEARING PLAYERS LIST...";
echo $conn->clearTable($T_GAMEPLAYERS);

echo "<BR/>CLEARING GAMES... ";
echo $conn->clearTable($T_ACTIVEGAMES);

echo "<BR/>CLEARING PLAYERS... ";
echo $conn->clearTable($T_PLAYERS);

echo "<BR/>CLEARING RULES... ";
echo $conn->clearTable($T_RULES);

//Create DB connection
$conn = New ChaosDB();

echo "<p>Adding Rule TEST</p>"; $conn->addRule("TEST", "This is a test rule");
foreach ($rChaos as $code => $text){ echo "<p>Adding Rule $code</p>"; $conn->addRule($code, $text); }
foreach ($rDurgs as $code => $text){ echo "<p>Adding Rule $code</p>"; $conn->addRule($code, $text); }
foreach ($rEnchant as $code => $text){ echo "<p>Adding Rule $code</p>"; $conn->addRule($code, $text); }
foreach ($rPersona as $code => $text){ echo "<p>Adding Rule $code</p>"; $conn->addRule($code, $text); }
foreach ($rPunishment as $code => $text){ echo "<p>Adding Rule $code</p>"; $conn->addRule($code, $text); }
foreach ($rWacky as $code => $text){ echo "<p>Adding Rule $code</p>"; $conn->addRule($code, $text); }

?>