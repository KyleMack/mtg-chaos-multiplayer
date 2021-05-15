"use strict";

const DEBUGGING = true;

const CONTENT_SELECTOR = "section#content";
const LOADING_TEMPLATE = "template#loading-page";
const CARD_TEMPLATE    = "template#card";


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

//Calls the create API endpoint
function callCreateAPI(){
    return new Promise((resolve, reject)=>{
        callAPI('create.php')
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