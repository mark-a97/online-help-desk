window.addEventListener("load", init);

function init() {

    
  var a = document.querySelector("#activeTab");
  a.addEventListener("click", active);

  var c = document.querySelector("#closedTab");
  c.addEventListener("click", closed);
  
  var add = document.querySelector("#btnCreateTicket");
  add.addEventListener("click", createTicket);

  
  var submit = document.querySelector("#submitTicket");
  submit.addEventListener("click", checkFields);

}

function checkFields(e) {
    var inputs = document.querySelectorAll(".input-type");
    var selects = document.querySelectorAll(".select-input");
    var description = document.querySelector("#create-ticket-description");

    for (var i = 0; i < inputs.length; i++) {  
        if(inputs[i].value.trim() === ""){
            inputs[i].style.borderColor = "#f74e4e";
            e.preventDefault();
        }
        else {
            inputs[i].style.borderColor = "#ccc";
        }
    }
    for (var i = 0; i < selects.length; i++) {  
        if(selects[i].value == "none" ){
            selects[i].style.borderColor = "#f74e4e";
            e.preventDefault();
        }
        else {
            selects[i].style.borderColor = "#ccc";
        }
    }
    if(description.value.trim() === ""){
        description.style.borderColor = "#f74e4e";
        e.preventDefault();
    }
    else {
        description.style.borderColor = "#ccc";
    }


}

function createTicket(e) {
    e.preventDefault();

    var x = document.querySelector("#create-ticket-popup");
    x.style.opacity = "1";
    x.style.left = "auto";



    x.style.display = "block";
    x.style.visibility = "visible";

    var dash = document.querySelector(".form-style-tickets");
    var wrapper = document.querySelector("#wrapper");

 
    dash.style.opacity = "0.1";
    wrapper.style.backgroundColor = "rgb(34, 33, 33)";
    wrapper.style.transition = "all 1s";

    document.querySelector("#close-btn").addEventListener("click", function() {
      
        x.style.left = "-999em";
        x.style.opacity = "0";
        dash.style.opacity = "1";    
        wrapper.style.backgroundColor = "lightgrey";
    });

    const textarea = document.querySelector("#create-ticket-description");

    textarea.addEventListener("input", event => {
      const target = event.currentTarget;
      const maxLength = target.getAttribute("maxlength");
      const currentLength = target.value.length;
      var tag = document.querySelector(".text-limit");
      tag.textContent = maxLength - currentLength + " characters remaining";
    });
}


function active(){
  var a = document.querySelector("#Active");
  var c = document.querySelector("#Closed");

  var aTab = document.querySelector("#activeTab");
  var cTab = document.querySelector("#closedTab");

  tab = "#Active";
  a.style.display = "block";
  a.className += " active";
  aTab.style.backgroundColor = "rgb(18 94 144)";

  c.style.display = "none";
  c.className.replace(" active", "");
  cTab.style.backgroundColor = "#2e79ab";

}

function closed(){
  var a = document.querySelector("#Active");
  var c = document.querySelector("#Closed");

  var aTab = document.querySelector("#activeTab");
  var cTab = document.querySelector("#closedTab");

  tab = "#Active";
  c.style.display = "block";
  c.className += " active";
  cTab.style.backgroundColor = "rgb(18 94 144)";

  a.style.display = "none";
  a.className.replace(" active", "");
  aTab.style.backgroundColor = "#2e79ab";
  
}