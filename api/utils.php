<?php




//Generates a game code from the list of existing codes
function generateGameCode(){

}

//Loads the list of game codes
function loadGameCodes(){
    //Load in the JSON file
    $gameCodes = loadJSONFile('../data/gameCodes.json');
    //Get a random value
    $suffix = array_rand($gameCodes);
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
    $json = json_decode($string);
    return $json;
}