"use strict";

const DEBUGGING = true;

const CONTENT_SELECTOR = "section#content";
const LOADING_TEMPLATE = "template#loading-page";


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

//Gets the template with the specified name
function getTemplate(templateName){
    var template = document.querySelector(templateName);
    var copy = template.content.cloneNode(true);
    return copy;  
}

//Calls the create API endpoint
function callCreateAPI(){
    respJSON = callAPI('create.php','POST',{});
    l(respJSON);
    return respJSON;
}

//Calls the API with the given parameters
async function callAPI(endpoint, method, body){
        //Call the fetch reqeust and wait for a response
        const response = await fetch(`http://kylecmackenzie.com/ChaosMultiplayer/api/v1/${endpoint}`, {
            method: method,
            mode: 'no-cors',
            cache: 'no-cache',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(body)
        });

        //Convert the response to JSON and return
        const json = await response.json();
        return json;
}

//Wrapper function for console output
function l(o){if(DEBUGGING){console.log(o);}}