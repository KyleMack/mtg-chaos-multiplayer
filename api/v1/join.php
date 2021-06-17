<?php

//Check that the required parameters are set
if( !isset( $_REQUEST["room_code"] ) ){
    echo json_encode( array("success"=>false, "message"=>"Error: room_code is a required parameter") );
    exit(0);
}

$game_code =  strtoupper( $_REQUEST["room_code"] );

if( empty( $game_code ) ){
    echo json_encode( array("success"=>false, "message"=>"Error: passed room code cannot be empty") );
    exit(0);
}

//Bring in core include file
include_once '../coreIncludes.php';

//Create DB connection
$conn = New ChaosDB();

//Check that the passed game code exists in the database
$doesExist = $conn->checkGameExists($game_code);

//If the game does not exist, return an error
if( !$doesExist ){
    echo json_encode( array("success"=>false, "message"=>"Error: room $game_code does not exist") );
    exit(0);
}

//Generate player Id's until a unique one is found
$uniqueId = false;

$playerId = null;
$playerName = generatePlayerName();

//Generate the player code
while( !$uniqueId ){
    $playerId = generatePlayerId();
    if( !$conn->checkPlayerExists($playerId) ){
        $uniqueId = true;
    }

}

//Commit the player to the database
$conn->savePlayer($playerId, $playerName);

//Create the linking record between the player and the game
$conn->addPlayerToGame($game_code, $playerId);

//TODO: Get the list of active rules

//Create the response array
$response = array();
$response["playerId"] = $playerId;
$response["playerName"] = $playerName;
$response["gameCode"] = $game_code;
$response["activePlayers"] = $conn->getPlayersInGame($game_code);
$response["activeRules"] = null;

echo json_encode( $response );
