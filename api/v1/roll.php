<?php

//Bring in core include file
include_once '../coreIncludes.php';

//Create DB connection
$conn = New ChaosDB();

//Check that the required parameters are set
if( !isset( $_REQUEST["type"] ) || empty($_REQUEST["type"]) ){
    echo json_encode( array("success"=>false, "message"=>"Error: type is a required parameter. Please pass either chaos, durgs, enchant, persona, punishment, or wacky") );
    exit(0);
}

$saveCode = false;
$roomCode = "";
//Check if the room code was passed
if( isset( $_REQUEST["room_code"] ) ){

    //If passed but empty, return an error
    if( empty( $_REQUEST["room_code"] ) ){
        echo json_encode( array("success"=>false, "message"=>"Error: passed room code cannot be empty") );
        exit(0);
    }

    //Save the room code locally
    $roomCode = $_REQUEST["room_code"];

    //If value passed, check that it exists
    $doesExist = $conn->checkGameExists($roomCode);

    //If the game does exist, set a flag to save the rule once selected
    if( $doesExist ){
        $saveCode = true;
    }
}

//Define constants for the incoming parameter
$R_CHAOS       = "CHAOS";
$R_DURGS       = "DURGS";
$R_ENCHANT     = "ENCHANT";
$R_PERSONA     = "PERSONA";
$R_PUNISHMENT  = "PUNISHMENT";
$R_WACKY       = "WACKY";

//Get the roll type and convert to uppercase
$rollType = strtoupper( $_REQUEST["type"] );

//Check the parameters to get the rule
$ruleCode = "";
switch($rollType){
    case "C":
        $ruleCode = 'C';
        break;
    case "D":
        $ruleCode = 'D';
        break;
    case "E":
        $ruleCode = 'E';
        break;
    case "P":
        $ruleCode = 'P';
        break;
    case "U":
        $ruleCode = 'U';
        break;
    case "W":
        $ruleCode = 'W';
        break;
    default:
        $ruleCode = 'C';
}

//Get a rule randomly from the database
$rule = $conn->getRandomRule($ruleCode);

//If a valid room code was passed, save the rule to the database
if( $saveCode ){

    $conn->addRuleToGame( $roomCode, $rule["rule_code"] );

}

//Create the array to hold the response
$response = array();

$response["saveCode"] = $saveCode;
$response["roomCode"] = $roomCode;
$response["ruleCode"] = $rule["rule_code"];
$response["ruleText"] = $rule["rule_text"];

echo json_encode( $response );
