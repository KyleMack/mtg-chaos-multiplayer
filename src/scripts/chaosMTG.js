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

            scheduleUpdate();
        })

        //If there was an error
        .catch(error => {
            displayErrorMessage();
            l(error);
        });


}

//Joins a room using the inputted room code 
async function joinRoom(){

    //Get the room code
    const roomCode = document.querySelector('#room-code-input').value;

    //Display the loading screen
    displayLoadingScreen();

    //Call the 'Join' API endpoint
    callJoinAPI(roomCode)

        //If the request was successful
        .then(json => {
            l(json);

            //Process the returned json
            processJoinData( json );

            displayControls();
            updateGame(true);
            
            scheduleUpdate();
        });

}

//Calls the roll endpoint for the appropriate roll type based on passed type
function roll(type = "CHAOS"){
	//Convert the passed type to uppercase
	const code = type.toUpperCase();
	let rollArg = "";
	switch(code){
		case 'CHAOS':
			rollArg = "CHAOS";
			break;
		case 'WORLD':
			rollArg = "WORLD";
			break;
		case 'PERSONA':
			rollArg = "PERSONA";
			break;
		case 'DURGS':
			rollArg = "DURGS";
			break;
		case 'PUNISHMENT':
			rollArg = "PUNISHMENT";
			break;
		case 'WACKY':
			rollArg = "WACKY";
			break;
		default:
            return;
	}

	//TODO: Perform fetch call
}

//Sets an interval API call to the 'Fetch' endpoint
function scheduleUpdate(delay = 7000){
    const timerRef = setInterval( updateGame, delay, true );
    setTimerRef( timerRef );
}

//Calls the 'Fetch' endpoint and pulls in the most recent game data
async function updateGame(performUpdate = false){

    //Call the 'Fetch' API endpoint to get the most recent game data
    callFetchAPI( getGameCode() )

        //If the request was successful
        .then( json => {
            l(json);

            //Process the returned data
            processFetchData( json );

            //If requested, update the screen
            if(performUpdate){
                updateScreen();
            }
        });
}
