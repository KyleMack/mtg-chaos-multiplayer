<?php

//Check that the required parameters are set
if( !isset( $_REQUEST["room_code"] ) ){
    echo json_encode( array("success"=>false, "message"=>"Error: room_code is a required parameter") );
    exit(0);
}

$game_code = $_REQUEST["room_code"];

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

//Pull in a list of all active players
$activePlayers = $conn->getPlayersInGame($game_code);

//TODO: Get the list of active rules
//TODO: Format the list to be json friendly
//TODO: Return





//Create the array to hold the response
$response = array();

$response["roomCode"] = $game_code;
$responst["activePlayers"] = $activePlayers;

echo json_encode( $response );
