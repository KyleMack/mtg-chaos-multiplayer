<?php

//Check that the required parameters are set
if( !isset( $_REQUEST["type"] ) || empty($_REQUEST["type"]) ){
    echo json_encode( array("success"=>false, "message"=>"Error: type is a required parameter. Please pass either chaos, durgs, enchant, persona, punishment, or wacky") );
    exit(0);
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

//Bring in core include file
include_once '../coreIncludes.php';

//Create DB connection
$conn = New ChaosDB();

//Get a rule randomly from the database
$rule = $conn->getRandomRule('C');

var_dump( $rule );