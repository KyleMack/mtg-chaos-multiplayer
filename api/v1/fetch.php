<?php

//Check that the required parameters are set
if( !isset( $_REQUEST["room_code"] ) ){
    echo "Error: room_code is required";
    exit(0);
}

//Bring in core include file
include_once '../coreIncludes.php';

//Create DB connection
$conn = New ChaosDB();


//TODO: Make sure that the passed game code exists and is valid
//TODO: Get the list of active players
//TODO: Get the list of active rules
//TODO: Format the list to be json friendly
//TODO: Return
