<?php




//Generates a game code from the list of existing codes
function generateGameCode(){
    //Get the game codes
    $codes = loadGameCodes();
    //Get a random value
    $suffix = $codes["codes"][array_rand($codes["codes"], 1)];
    //Create array of numbers
    $numbers = array("0","1","2","3","4","5","6","7","8","9");
    //Get a random number and add it to the end
    $newCode = $suffix . array_rand($numbers, 1);

    return $newCode;
}

//Loads the list of game codes
function loadGameCodes(){
    //Load in the JSON file
    $gameCodes = loadJSONFile('../data/gameCodes.json');

    return $gameCodes;    
}

//Loads the player codes and returns the array object
function loadPlayerCodes(){
    //TODO
}

//Loads the chaos rules and returns the array object
function loadChaosRules(){
    //TODO
}

//Loads a JSON file from the file systems 'data' directory
function loadJSONFile($fileName = null){
    if($fileName === null){
        return null;
    }

    $string = file_get_contents($fileName);
    $json = json_decode($string, true);
    return $json;
}