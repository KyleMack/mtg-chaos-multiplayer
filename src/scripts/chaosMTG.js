"use strict";

 

//Begins the process of creating a new room from the login page
function createNewRoom(){

    let roomCode = null;

    //Display the loading screen
    displayLoadingScreen();

    //TODO: 

    //Send the fetch request to create the room and return the room code
    roomCode = requestRoomCode();

    //If the request was successful...

    //...save the room code...

    //...and display the main window

    //if the request failed...

    //...display the error...

    //...and try again
}

//Displays the loading screen
function displayLoadingScreen(){
    updateContent( getLoadingContent() );
}

//Submits the request for a new room code
function requestRoomCode(){
    callCreateAPI();
}