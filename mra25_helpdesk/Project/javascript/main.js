window.addEventListener("load", init);

function init(){
	
    var sPath = window.location.pathname;
    var sPage = sPath.substring(sPath.lastIndexOf('/') + 1);

    var mql = window.matchMedia('(max-width: 600px)');
    var nav = document.querySelector("#side-nav");
    var navBar = document.querySelector(".sideNavBar");
    var active = document.querySelector(".side-nav-active");

    if(sPage !== "register.php"){
        if(sPage !== "login.php"){
                    
            var mobileS = document.querySelector("#burger-i");
            mobileS.addEventListener("click", mobileNav);

            var noti = document.querySelector(".notif-icon");
            noti.addEventListener("click", showNotifications);

            var clicked = document.querySelector("#profile");
            clicked.addEventListener("click", displayLogout);

            loadDoc();
            loadDoc2();

            function screenTest(e) {    
                if (e.matches) {
                    /* the viewport is 600 pixels wide or less */
                    nav.className = 'side-nav';
                    navBar.style.marginLeft = "0";
                    // active.style.marginLeft = "15em";
                    // nav.style.display = 'none';
                } else {
                    /* the viewport is more than than 600 pixels wide */
                    nav.className = 'side-nav-active';
                    // active.style.marginLeft = "1em";
                
                }
            
            }
            mql.addEventListener('change', screenTest);
        }
        
    }
    // checkPage();
}

var errors = 0;
var returnedMessage = "";
var NULL = ""; 
var clicked = false;
  
function checkPage(){

    const currPage = document.querySelector("#page-name").textContent;
    if(currPage == "login"){      
        document.querySelector("#btnLogin").addEventListener("click", function(e) {

            const emailInput = document.querySelector("#email-login").value;
            
           if(clicked == true){
                var div = document.querySelector(".error-div");
                var p = document.querySelector(".error-message");
                div.remove();
                p.remove();
                clicked = false;
           }

            valueChecks(emailInput, "Email", NULL, 255, 10);

            if(errors > 0){
                e.preventDefault();
                var mainElement = document.querySelector("main");
                var div = document.createElement("div");
                var p = document.createElement("p");
                div.setAttribute("class", "error-div");
                p.setAttribute("class", "error-message");
                mainElement.insertBefore(div, mainElement.firstChild);
                div.appendChild(p);
                p.textContent = returnedMessage;
                clicked = true;
            }
        });
    }

    else if(currPage == "register"){
        document.querySelector("#btnRegister").addEventListener("click", function(e) {
            errors = 0;

            const username = document.querySelector("#input-username").value;
            const forename = document.querySelector("#input-forename").value;
            const surname = document.querySelector("#input-surname").value;
            const mobile = document.querySelector("#input-mobile").value;
            const email = document.querySelector("#input-email").value;
            const pass = document.querySelector("#input-pass").value;
            const passConfirm = document.querySelector("#input-confirm").value;

            if(clicked == true){
                 var div = document.querySelector(".error-div");
                 var p = document.querySelector(".error-message");
                 div.remove();
                 p.remove();
                 clicked = false;
            }

             valueChecks(username, "Username", NULL, 255, 4);
             valueChecks(forename, "First name", "TEXT_ONLY", 255, 1);
             valueChecks(surname, "Surname", "TEXT_ONLY", 255, 1);
             valueChecks(mobile, "Mobile", "TEXT_ONLY", 11, 11);
             valueChecks(email, "Email", NULL, 255, 10);
             valueChecks(pass, "Password", NULL, 255, 8);
             valueChecks(passConfirm, "Password", NULL, 255, 8);

             if(errors > 0){
                 e.preventDefault();
                 var mainElement = document.querySelector("main");
                 var div = document.createElement("div");
                 var p = document.createElement("p");
                 div.setAttribute("class", "error-div");
                 p.setAttribute("class", "error-message");
                 mainElement.insertBefore(div, mainElement.firstChild);
                 div.appendChild(p);
                 p.textContent = returnedMessage;
                 clicked = true;
             }
         });
    }
    else if(currPage == "Dashboard"){
    //     document.querySelector(".submit-btn").addEventListener("click", function(e) {
    //         errors = 0;
            
    //         const forename = document.querySelector("#input-forename").value;
    //         const surname = document.querySelector("#input-surname").value;
    //         const username = document.querySelector("#input-username").value;
    //         const email = document.querySelector("#input-email").value;
    //         const confirmEmail = document.querySelector("#input-confirm-email").value;
    //         const mobile = document.querySelector("#input-mobile").value;
    //         const passOld = document.querySelector("#input-password-old").value;
    //         const pass = document.querySelector("#input-password").value;
    //         const passConfirm = document.querySelector("#input-password-confirm").value;

    //         if(clicked == true){
    //              var div = document.querySelector(".error-div");
    //              var p = document.querySelector(".error-message");
    //              div.remove();
    //              p.remove();
    //              clicked = false;
    //         }

    //         valueChecks(forename, "First name", "TEXT_ONLY", 255, 1);
    //         valueChecks(surname, "Surname", "TEXT_ONLY", 255, 1);
    //         valueChecks(username, "Username", NULL, 255, 4);
    //         valueChecks(email, "Email", NULL, 255, 10);
    //         valueChecks(confirmEmail, "Email", NULL, 255, 10);
    //         valueChecks(mobile, "Mobile", "TEXT_ONLY", 11, 11);
    //         valueChecks(passOld, "Password", NULL, 255, 8);
    //         valueChecks(pass, "Password", NULL, 255, 8);
    //         valueChecks(passConfirm, "Password", NULL, 255, 8);

    //          if(errors > 0){
    //              e.preventDefault();
    //             //  var mainElement = document.querySelector("main");
    //              var div = document.createElement("div");
    //              var p = document.createElement("p");
    //              var c = document.querySelector(".form-style")
    //              div.setAttribute("class", "error-div");
    //              p.setAttribute("class", "error-message");
    //              c.insertBefore(div, c.firstElementChild.nextSibling);
    //              div.appendChild(p);
    //              p.textContent = returnedMessage;
    //              clicked = true;
    //          }
    //      });
    }
  
}

// function alphanumeric(value){
//     var str = value.match(/^[a-z0-9]+$/i);
//     console.log(str.value);
//     if(str != null){
//         console.log(match);
//         return true;
//     }
//     else {
//         console.log(match);
//         return false;
//     }
// }

function is_numeric(number){    
    var numbers = /^[0-9]+$/;
    if(number.match(numbers)){
        return true;
    }
    else{
        return false;
    }
}


function valueChecks(value, type, alphaNumeric, max_length, min_length){
    const NULL = "";
    value.trim();
    if(alphaNumeric != NULL){
        if(alphaNumeric == "YES"){
            if(!alphanumeric(value)){
                errors ++;
                returnedMessage = type + " must be alpha numerical";
            }
        }
        // else if(alphaNumeric == "NO"){
        //     if(alphanumeric(value)){
        //         errors ++;
        //         returnedMessage = type + " must not be alpha numerical";
        //     }
        // }
        // if(alphaNumeric == "NUMBERS_ONLY"){
        //     if(!is_numeric(value)){
        //         errors ++;
        //         returnedMessage = type + " must not contain letters";
        //     }

        // }
        else if(alphaNumeric == "TEXT_ONLY"){

        }
    }

    if(type == "Mobile"){
        if(!is_numeric(value)){
            errors ++;
            returnedMessage = "Mobile can only be numerical";
        }
    }
     else if(type == "Password"){
        var lowercase = /[a-z]/g
        var uppercase = /[A-Z]/g
        var number = /[0-9]/g
        var specialChars =  /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/;
        var returned;

        if(value.match(lowercase)){
            lowercase = true;
        }
        else {
            lowercase = false;
        }
    
        if(value.match(uppercase)){
            uppercase = true;
        }
        else {
            uppercase = false;
        }

        if(value.match(number)){
            number = true;
        }
        else {
            number = false;
        }

        if(specialChars.test(value)){
            specialChars = true;
        }
        else {
            specialChars = false;
        }

        if(!uppercase || !lowercase || !number || !specialChars) {
            errors ++;
            returnedMessage = "Password requirements: 8 characters, one lowercase, one uppercase, one number, and one special character";
        }
    }

    if(value.length > max_length){
        errors ++;
        returnedMessage = type + " must be of suitable length (too high)";

    }
    else if(value.length < min_length){
        errors ++;
        returnedMessage = type + " must be of suitable length (too small)";
    }
}


function displayLogout(){
    console.log("clicked");
    var dropdown = document.querySelector('.dropdown-content-name');
    if(dropdown.style.display == "block"){
        dropdown.style.display = "none";
    }
    else {
        dropdown.style.display = "block";
    }
}


function showNotifications(){
    var form = document.querySelector('.notification-box');
    if(form.style.display == "block"){
        form.style.display = "none";
    }
    else {
    form.style.display = "block";
    }
}

function loadDoc() {
  

    setInterval(function(){
  
     var xhttp = new XMLHttpRequest();
     xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
       document.getElementById("notif_test").innerHTML = this.responseText;

      }
     };     

     xhttp.open("GET", "notifications/noti_list.php", true);
     xhttp.send();
  
    },1000);
  
  
   }
   function loadDoc2() {
  

    setInterval(function(){
  
     var xhttp = new XMLHttpRequest();
     xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
       document.getElementById("noti_number").textContent = this.responseText;

      }
     };
     xhttp.open("GET", "notifications/noti_num.php", true);
     xhttp.send();
  
    },1000);
  
  
   }
	
function mobileNav() {
    var navlist = document.querySelector("#side-nav");
    var nav = document.querySelector(".sideNavBar");
    var width = document.documentElement.clientWidth;

    if(navlist.className == "side-nav-active"){
        // nav.style.display = 'none';
        if(width > 600){
        nav.style.marginLeft = '-13em';
        
        }
        else {
            nav.style.display = "block";
        }
        
            // nav.style.display = "none";
        navlist.className = 'side-nav';
    }
    else {
        if(width > 600){
            nav.style.marginLeft = '0';
        }
        else {
            // nav.style.display = "none";
        }
        
            // nav.style.display = "block";
        
        navlist.className = 'side-nav-active';
    }
}

