"use strict";

//Displays the home page
function displayHomeScreen(){
    updateContent( getHomePageContent() );
}

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
    const rules = getActiveRules();
    let rulesHTML = [];
    for(let i = 0; i < rules.length; i++){
	rulesHTML.push( rules[i].text );
    }
    document.querySelector("#room-rules-display").innerHTML = createHTMLList( rulesHTML );

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

	    updateGame();
	    setTimeout(()=>{displayControls();updateScreen();}, 5000);

            scheduleUpdate();
        })

        //If there was an error
        .catch(error => {
            displayErrorMessage();
            l(error);
        });


}

//Joins a room using the inputted room code 
async function joinRoom(codeOverride = null){

    //Get the room code
    const roomCode = ( codeOverride === null ? document.querySelector('#room-code-input').value : codeOverride );

    //Display the loading screen
    displayLoadingScreen();

    //Call the 'Join' API endpoint
    callJoinAPI(roomCode)

        //If the request was successful
        .then(json => {
            l(json);

	    //If the join was not successful, display an error and reload the page
	    if( json["success"] == false ){
	    	displayErrorMessage();
		setTimeout( displayJoinRoomScreen, 5000 );
		return;
	    }

	    //Process the returned json
            processJoinData( json );

            displaySuccessMessage(json["gameCode"], json["playerName"]);
	
	    updateGame();
	    setTimeout(()=>{displayControls();updateScreen();}, 5000);
            
            scheduleUpdate();
        });

}

//Checks for the URL parameter 'room' and tries to connect to the passed room
function checkAutoJoin(){
	//Grab the parameters and check for 'room'
	const params = new URLSearchParams(window.location.search);
	if( !params.has('room') ){
		//If the parameter isn't set, do nothing
		return;
	}

	//If the room param is set, trigger the join process with the room
	joinRoom(params.get('room'));
}

//Calls the roll endpoint for the appropriate roll type based on passed type
function roll(type = "CHAOS"){
	//Convert the passed type to uppercase
	const code = type.toUpperCase();
	let rollArg = "";
	switch(code){
		case 'CHAOS':
			rollArg = "C";
			break;
		case 'ENCHANT':
			rollArg = "E";
			break;
		case 'PERSONA':
			rollArg = "P";
			break;
		case 'DURGS':
			rollArg = "D";
			break;
		case 'PUNISHMENT':
			rollArg = "U";
			break;
		case 'WACKY':
			rollArg = "W";
			break;
		default:
			break;
            return;
	}
	console.log(`Rolling w/code ${rollArg}`);
	//Perform the fetch call the the roll api with the roll type and game code
	callRollAPI( rollArg, getGameCode() )
		.then( json => {
			updateGame(true);
		});



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

/****************************************************************/
//Check for auto join
checkAutoJoin();

