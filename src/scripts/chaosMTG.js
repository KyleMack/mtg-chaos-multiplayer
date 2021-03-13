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
        })

        //If there was an error
        .catch(error => {
            l(error);
        });

    //TODO: 

    
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

//Creates a spinning card element
function createCard(){
    //Get the card element
    let card = getCardTemplate();
}