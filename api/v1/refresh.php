<?php

//Bring in core include file
include_once '../coreIncludes.php';

$T_PLAYERS     = "players";
$T_ACTIVEGAMES = "active_games";
$T_GAMEPLAYERS = "game_players";
$T_GAMERULES   = "game_rules";

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

?>