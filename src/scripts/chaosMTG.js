"use strict";


//Displays the loading screen
function displayLoadingScreen(){
    updateContent( getLoadingContent() );
}

//Displays the 'Join Room' input screen
function displayJoinRoomScreen(){
    updateContent( getJoinRoomContent() );
}

//Updates the loading screen to display a success message
function displaySuccessMessage(gameCode, playerName){
    document.querySelector("#loading-message").innerHTML = "Finalizing Game...";
    document.querySelector("#loading-text").innerHTML = `Finalizing game [${gameCode}] for player [${playerName}]...`;
}

//Updates the loading screen to display an error
function displayErrorMessage(){
    document.querySelector("#loading-message").innerHTML = "Error creating game...";
    document.querySelector("#loading-text").innerHTML = `Something went wrong, please contact the administrator or try again later`;
}

//Creates a spinning card element
function createCard(){
    //Get the card element
    let card = getCardTemplate();
}

//Displays the controls page once the game is loaded
function displayControls(){
    updateContent( getControlsContent() );
}

//Updates all information on the screen with what is stored in the window.chaos object
function updateScreen(){

    //Display Room Code
    document.querySelector("#room-code-display").innerHTML = getGameCode();

    //Display Active Players
    document.querySelector("#room-players-display").innerHTML = createHTMLList( getPlayersList() );

    //Display Active Rules
    document.querySelector("#room-rules-display").innerHTML = createHTMLList( getActiveRules() );

}


//Begins the process of creating a new room from the login page
async function createNewRoom(){

    //Display the loading screen
    displayLoadingScreen();

    //Send the fetch request to create the room and return the room code
    callCreateAPI()

        //If the reqeust was successful
        .then(json => {
            l(json);

            displaySuccessMessage(json["gameCode"], json["playerName"]);
            setPlayerId(json["playerId"]);
            setPlayerName(json["playerName"]);
            setGameCode(json["gameCode"]);

            displayControls();
            updateGame(true);

        })

        //If there was an error
        .catch(error => {
            displayErrorMessage();
            l(error);
        });


}

//Joins a room using the inputted room code 
async function joinRoom(){

}

//Calls the 'Fetch' endpoint and pulls in the most recent game data
async function updateGame(updateScreen = false){

    //Call the 'Fetch' API endpoint to get the most recent game data
    callFetchAPI( getGameCode() )

        //If the request was successful
        .then( json => {
            l(json);

            processFetchData( json );

            if(updateScreen){
                updateScreen();
            }
        });
}