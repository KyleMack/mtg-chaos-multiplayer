<?php

error_reporting(E_ALL);
ini_set("display_errors","On");

//Bring in core include file
include_once '../coreIncludes.php';

//Create DB conneciton and to Admin
$conn = new DatabaseConn();
include '../SetDBAdmin.php';

//Generate the random code and player name
$newCode = generateGameCode();
$playerName = generatePlayerName();

//TODO:
//Commit the game code and name to the database

//Create a assoc array for the JSON response
$response = array(  "code"=>$newCode,
                    "success"=>"true",
                    "playerName"=>$playerName);

//Encode the response
echo json_encode($response);

?>