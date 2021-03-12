<?php

error_reporting(E_ALL);
ini_set("display_errors","On");

//Bring in core include file
include_once '../coreIncludes.php';

//Create DB connection
$conn = New ChaosDB();

//Select all active games
$players = $conn->getAllPlayers();

//return the games as JSON
return json_encode($players);