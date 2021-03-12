<?php

error_reporting(E_ALL);
ini_set("display_errors","On");

//Bring in core include file
include_once '../coreIncludes.php';

//Generate the random code and player name
$newCode = generateGameCode();
$playerName = generatePlayerName();
$playerCode = generatePlayerCode();

//Create DB connection
$conn = New ChaosDB();

//Commit the player to the database
$conn->savePlayer($playerCode, $playerName);

//TODO:
//Commit the game to the database

//Create a assoc array for the JSON response
$response = array(  "code"=>$newCode,
                    "success"=>"true",
                    "playerName"=>$playerName);

//Encode the response
echo json_encode($response);

?>