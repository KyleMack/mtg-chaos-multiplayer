<?php

//Check that the required parameters are set
if( !isset( $_REQUEST["type"] ) || empty($_REQUEST["type"]) ){
    echo json_encode( array("success"=>false, "message"=>"Error: type is a required parameter. Please pass either chaos, durgs, enchant, persona, punishment, or wacky") );
    exit(0);
}

//Define constants for the incoming parameter
const R_CHAOS       = "CHAOS";
const R_DURGS       = "DURGS";
const R_ENCHANT     = "ENCHANT";
const R_PERSONA     = "PERSONA";
const R_PUNISHMENT  = "PUNISHMENT";
const R_WACKY       = "WACKY";

//Get the roll type and convert to uppercase
$rollType = strtoupper( $_REQUEST["type"] );

//Bring in core include file
include_once '../coreIncludes.php';

//Create DB connection
$conn = New ChaosDB();

//Get a rule randomly from the database
$rule = $conn->getRandomRule('C');

var_dump( $rule );