"use strict";

 

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
            updateScreen();

        })

        //If there was an error
        .catch(error => {
            displayErrorMessage();
            l(error);
        });


}

//Displays the loading screen
function displayLoadingScreen(){
    updateContent( getLoadingContent() );
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
    document.querySelector("#room-players-display").innerHTML = createHTMLList( getActivePlayers() );

    //Display Active Rules
    document.querySelector("#room-rules-display").innerHTML = createHTMLList( getActiveRules() );

}