module.exports = class init {
    vars = require("./globalVars.js");

    constructor() {
        if(document.querySelector('[data-debug-analytical-js="true"]')){
            this.debug = true;
        } else {
            this.debug = false;
        }
    }

    /* For debug messages in debug mode */
    debugMessage(message) {
        if(this.debug == true){
            console.log(message);
        }
    }

}