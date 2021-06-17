<?php

//Set to true to allow debugging
$DEBUGGING = true;

error_reporting(E_ALL);
ini_set("display_errors","On");

//Bring in core include file
include_once '../coreIncludes.php';

//Generate the random code and player name
$gameCode = generateGameCode();
$playerName = generatePlayerName();
$playerId = generatePlayerId();

//Create DB connection
$conn = New ChaosDB();

//Commit the player to the database
$conn->savePlayer($playerId, $playerName);

//Commit the game to the database
$conn->saveGame($gameCode, $playerId);

//Create the linking record between the player and the game
$conn->addPlayerToGame($gameCode, $playerId);

//Create a assoc array for the JSON response
$response = array(  "gameCode"=>$gameCode,
                    "playerId"=>$playerId,
                    "success"=>"true",
                    "playerName"=>$playerName);

//Encode the response
echo json_encode($response);

?>
