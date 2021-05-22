<?php

//Bring in core include file
include_once '../coreIncludes.php';

const T_PLAYERS     = "players";
const T_ACTIVEGAMES = "active_games";
const T_GAMEPLAYERS = "game_players";
const T_GAMERULES   = "game_rules";

$conn = New DatabaseConn();

//Delete and re-create the tables
echo "DELETING TABLES...<BR/>";

echo "DELETING PLAYERS...<BR/>";
$conn->dropTable(T_PLAYERS);

echo "DELETING GAMES...<BR/>";
$conn->dropTable(T_ACTIVEGAMES);

echo "DELETING PLAYERS LIST...<BR/>";
$conn->dropTable(T_GAMEPLAYERS);

echo "DELETING RULES LIST...<BR/>";
$conn->dropTable(T_GAMERULES;

echo "CREATING TABLES...<BR/>";

echo "CREATING PLAYERS...<BR/>";
$conn->createTable(T_PLAYERS);

echo "CREATING GAMES...<BR/>";
$conn->createTable(T_ACTIVEGAMES);

echo "CREATING PLAYERS LIST...<BR/>";
$conn->createTable(T_GAMEPLAYERS);

echo "CREATING RULES LIST...<BR/>";
$conn->createTable(T_GAMERULES;
