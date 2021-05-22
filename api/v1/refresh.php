<?php

//Bring in core include file
include_once '../coreIncludes.php';

$T_PLAYERS     = "players";
$T_ACTIVEGAMES = "acTive_games";
$T_GAMEPLAYERS = "game_players";
$T_GAMERULES   = "game_rules";

$conn = New DatabaseConn();

//Delete and re-create the tables
echo "DELETING TABLES...<BR/>";

echo "DELETING PLAYERS...<BR/>";
$conn->dropTable($T_PLAYERS);

echo "DELETING GAMES...<BR/>";
$conn->dropTable($T_ACTIVEGAMES);

echo "DELETING PLAYERS LIST...<BR/>";
$conn->dropTable($T_GAMEPLAYERS);

echo "DELETING RULES LIST...<BR/>";
$conn->dropTable($T_GAMERULES;

echo "CREATING TABLES...<BR/>";

echo "CREATING PLAYERS...<BR/>";
$conn->clearTable($T_PLAYERS);

echo "CREATING GAMES...<BR/>";
$conn->clearTable($T_ACTIVEGAMES);

echo "CREATING PLAYERS LIST...<BR/>";
$conn->clearTable($T_GAMEPLAYERS);

echo "CREATING RULES LIST...<BR/>";
$conn->clearTable($T_GAMERULES;

?>