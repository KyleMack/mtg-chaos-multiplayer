<?php

//Bring in core include file
include_once '../coreIncludes.php';

$T_PLAYERS     = "players";
$T_ACTIVEGAMES = "acTive_games";
$T_GAMEPLAYERS = "game_players";
$T_GAMERULES   = "game_rules";

$conn = New DatabaseConn();


echo "CLEARING TABLES...<BR/>";

echo "CLEARING PLAYERS...<BR/>";
$conn->clearTable($T_PLAYERS);

echo "CLEARING GAMES...<BR/>";
$conn->clearTable($T_ACTIVEGAMES);

echo "CLEARING PLAYERS LIST...<BR/>";
$conn->clearTable($T_GAMEPLAYERS);

echo "CLEARING RULES LIST...<BR/>";
$conn->clearTable($T_GAMERULES);

?>