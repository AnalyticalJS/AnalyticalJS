import { init } from "./analytical.js";
let System = new init();

window.onload = function(){

        /* Initilising Analytical.JS */
        startUp();
        
        function startUp(){
            if(System.vars.failed == false){
                if(System.vars.userIP != ""){
                    init();
                } else {
                    setTimeout( () => { startUp(); }, 1 );
                }
            }
        }

        function init(){
            System.debugMessage("Analytical.js intilised");
            System.debugMessage(System.vars.referrerDomain);
        }
}
