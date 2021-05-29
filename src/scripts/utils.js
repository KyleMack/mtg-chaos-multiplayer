"use strict";

const DEBUGGING = true;

const CONTENT_SELECTOR  = "section#content";
const LOADING_TEMPLATE  = "template#loading-page";
const CARD_TEMPLATE     = "template#card";
const CONTROLS_TEMPLATE = "template#interface";
const JOIN_TEMPLATE     = "template#join-room"; 

const STORAGE_GAME_CODE      = "MTG_CHAOS_GAME_CODE";
const STORAGE_PLAYER_ID      = "MTG_CHAOS_PLAYER_ID";
const STORAGE_PLAYER_NAME    = "MTG_CHAOS_PLAYER_NAME";

//Adds a new object under the window object for global storage 
function initializeData(){

    //Store all variables in the created window.chaos object
    window.chaos = {}

    //Store the window object and create the variables to be used
    let _c = window.chaos;
    
    _c.playerId = null;     //Unique ID of the player
    _c.playerName = null;   //Name of the player
    _c.gameCode = null;     //Unique ID of the game
    _c.activePlayers = [];  //List of currently active players
    _c.activeRules = [];    //List of currently active rules

}

//Accepts the JSON response from a 'Fetch' API call 
function processFetchData(json){
    setGameCode( json["roomCode"] );
    setActivePlayers( json["activePlayers"] );
}

//Accepts the JSON response from a 'Join' API call
function processJoinData(json){
    setPlayerId( json["playerId"] );
    setPlayerName( json["playerName"] );
    setGameCode( json["gameCode"] );
    setActivePlayers( json["activePlayers"] );
    setActiveRules( json["activeRules"] );
}

function getPlayerId(){ return window.chaos.playerId; }
function setPlayerId(playerId){ window.chaos.playerId = playerId; }

function getPlayerName(){ return window.chaos.playerName; }
function setPlayerName(playerName){ window.chaos.playerName = playerName; }

function getGameCode(){ return window.chaos.gameCode; }
function setGameCode(gameCode){ window.chaos.gameCode = gameCode; }

function getActivePlayers(){ return window.chaos.activePlayers; }
function setActivePlayers(activePlayers){ window.chaos.activePlayers = activePlayers; }

function getActiveRules(){ return window.chaos.activeRules; }
function setActiveRules(activeRules){ window.chaos.activeRules = activeRules; }

//Updates the content of the main page with the provided HTML string
function updateContent(html){
    //Update the content section with the attached HTML
    document.querySelector(CONTENT_SELECTOR).innerHTML = "";
    document.querySelector(CONTENT_SELECTOR).appendChild(html);
}

//Gets the content for the 'Loading' page
function getLoadingContent(){
    return getTemplate(LOADING_TEMPLATE);
}

//Gets the content for the 'Join Room' page
function getJoinRoomContent(){
    return getTemplate(JOIN_TEMPLATE);
}

function getControlsContent(){
    return getTemplate(CONTROLS_TEMPLATE);
}

//Gete the content for the 'Card' element
function getCardTemplate(){
    return getTemplate(CARD_TEMPLATE);
}

//Gets the template with the specified name
function getTemplate(templateName){
    var template = document.querySelector(templateName);
    var copy = template.content.cloneNode(true);
    return copy;  
}

//Accepts a list of items and returns a string of <li> items
function createHTMLList(items,itemClass = ""){

    let html = "";

    //If there are no items, return
    if(items.length === 0){ return html; }

    //For each item, append <li>item</li>
    for(let i = 0; i < items.length; i++){
        html += `<li class="${itemClass}">${items[i]}</li>`;
    }

    return html;

}

//Returns the list of players to display 
function getPlayersList(){
    const players = getActivePlayers();
    const m = getPlayerName();

    //Sort the list to have the players name in the front
    const sortedList = players.sort( (x,y) => { return x == m ? -1 : y == m ? 1 : 0 } );

    return sortedList;
}

//Calls the create API endpoint
function callCreateAPI(){
    return new Promise((resolve, reject)=>{
        callAPI('create.php')
            .then(json=>resolve(json));
    });
}

//Calls the fetch API endpoint using the passed room code
function callFetchAPI(roomCode){
    return new Promise((resolve, reject) => {
        callAPI(`fetch.php?room_code=${roomCode}`)
            .then(json=>resolve(json));
    });
}

//Calls the Join API endpoing using the passed room code
function callJoinAPI(roomCode){
    return new Promise((resolve, reject)=>{
        callAPI(`join.php?room_code=${roomCode}`)
            .then(json=>resolve(json));
    });
}

//Calls the API with the given parameters
function callAPI(endpoint){
    return new Promise((resolve, reject)=>{
        
    //Call the fetch reqeust and wait for a response
    fetch(`http://kylecmackenzie.com/ChaosMultiplayer/api/v1/${endpoint}`, {
        headers: {
            'Content-Type': 'application/json'
        }
    })
        .then(data => resolve(data.json()));

    });
}

//Wrapper function for console output
function l(o){if(DEBUGGING){console.log(o);}}


//Initialize data
initializeData();