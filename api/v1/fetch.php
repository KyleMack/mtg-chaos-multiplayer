<?php

//Check that the required parameters are set
if( !isset( $_REQUEST["room_code"] ) ){
    echo json_encode( array("success"=>false, "message"=>"Error: room_code is a required parameter") );
    exit(0);
}

const game_code = $_REQUEST["room_code"];

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

//TODO: Make sure that the passed game code exists and is valid
//TODO: Get the list of active players
//TODO: Get the list of active rules
//TODO: Format the list to be json friendly
//TODO: Return
