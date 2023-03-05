import { data } from "browserslist";

/* Global Variables */

var details = initDetails();
export var website = process.env.APP_URL;
export var siteDomain = window.location.hostname;
export var userIP = "";
export var referrer = "";
export var referrerDomain = "";
export var failed = false;
export var id = "";
export var debug = false;

async function initDetails(){
    var theResponse;
    if(process.env.NODE_ENV == "production"){
        var url = process.env.MIX_APP_URL_PROD+"/api/initDetails";
    } else {
        var url = process.env.MIX_APP_URL+"/api/initDetails";
    }
    fetch(url, {
        headers: {
          'Accept': 'application/json',
          'Content-Type': 'application/json'
        },
        method: "POST",
        body: JSON.stringify({referrer: document.referrer, page: document.URL})
    }).then( (response) => response.json() ).then((responseData) => {
    });
    return theResponse;
}

/* End Global Vars */