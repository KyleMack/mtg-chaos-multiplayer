<?php

error_reporting(E_ALL);
ini_set("display_errors","On");

//Bring in core include file
include_once '../coreIncludes.php';

//Create DB connection
$conn = New ChaosDB();

//Select all active games
$games = $conn->getAllActiveGames();

//return the games as JSON
echo "Active Games:<br/>";

echo json_encode($games);

echo "<br/>";

//Select all active players
$players = $conn->getAllPlayers();

//return the players as JSON
echo "Active Players:<br/>";

echo json_encode($players);

