window.addEventListener("load", init);

function init(){
	
	//MAIN PAGE//

	var btnAdd = document.querySelector("#btnAddFaq");
  var btnDel = document.querySelector("#btnRemoveFaq");
    
	
    // var btnHide = document.querySelector("#btnCloseFaq");
    // btnHide.addEventListener("click", hideForm);

    if(btnAdd) {
      btnAdd.addEventListener("click", showForm);
      
    }
    if(btnDel) {
      btnDel.addEventListener("click", delFaq);
    }

    
    var faqChecks = document.querySelector("#addQuestion");
    if(faqChecks){
      faqChecks.addEventListener("click", checkFields);
    }

    var faqDel = document.querySelector("#deleteQuestion");
    if(faqDel){
      faqDel.addEventListener("click", checkDelFields);
    }

    faqShow();
}



function checkFields(e) {
    var x = document.querySelectorAll(".faq-inputs");
    for (var i = 0; i < x.length; i++) {
        if(x[i].value.trim() == ""){
            x[i].style.borderColor = "#f74e4e";
            e.preventDefault();
        }
        else {
            x[i].style.borderColor = "#ccc";
        }
    }
}

function checkDelFields(e) {
    var x = document.querySelector("#select-question");
    var y = document.querySelector("#faq-textarea");
    
    if(x.value == "none" ){
        x.style.borderColor = "#f74e4e";
        e.preventDefault();
    }
    else {
        x.style.borderColor = "#ccc";
    }

    if(y.value.trim() == ""){
        y.style.borderColor = "#f74e4e";
        e.preventDefault();
    }
    else {
        y.style.borderColor = "#ccc";
    }
}


function faqShow() {
    var acc = document.getElementsByClassName("accordion");
    var i;
    for (i = 0; i < acc.length; i++) {
      acc[i].addEventListener("click", function() {
        this.classList.toggle("active");
        var panel = this.nextElementSibling;
        if (panel.style.maxHeight) {
          panel.style.maxHeight = null;
        } else {
          panel.style.maxHeight = panel.scrollHeight + "px";
        } 
      });
    }
}

function delFaq() {
  var x = document.querySelector("#remove-faq-popup");
  x.style.opacity = "1";
  x.style.left = "auto";

  var dash = document.querySelector(".form-style");
  var wrapper = document.querySelector("#wrapper");


  dash.style.opacity = "0.1";
  wrapper.style.backgroundColor = "rgb(34, 33, 33)";
  wrapper.style.transition = "all 1s";

const textarea = document.querySelector("#faq-textarea");

    textarea.addEventListener("input", event => {
      const target = event.currentTarget;
      const maxLength = target.getAttribute("maxlength");
      const currentLength = target.value.length;
      var tag = document.querySelector("#add-textarea");
      tag.textContent = maxLength - currentLength + " characters remaining";
    });



  document.querySelector("#close-btn-faq").addEventListener("click", function() {
    form = document.querySelector(".popup-create-ticket");
    dash = document.querySelector(".form-style");
    wrapper = document.querySelector("#wrapper");

    x.style.left = "-999em";
    x.style.opacity = "0";
    dash.style.opacity = "1";    
    wrapper.style.backgroundColor = "lightgrey";
});
}

function showForm(){
  var x = document.querySelector("#create-ticket-popup");
    x.style.opacity = "1";
    x.style.left = "auto";

    var dash = document.querySelector(".form-style");
    var wrapper = document.querySelector("#wrapper");

 
    dash.style.opacity = "0.1";
    wrapper.style.backgroundColor = "rgb(34, 33, 33)";
    wrapper.style.transition = "all 1s";

    const textarea = document.querySelector("#faq-add-textarea");

    textarea.addEventListener("input", event => {
      const target = event.currentTarget;
      const maxLength = target.getAttribute("maxlength");
      const currentLength = target.value.length;
      var tag = document.querySelector(".text-limit");
      tag.textContent = maxLength - currentLength + " characters remaining";
    });

 

    document.querySelector("#close-btn").addEventListener("click", function() {
      form = document.querySelector(".popup-create-ticket");
      dash = document.querySelector(".form-style");
      wrapper = document.querySelector("#wrapper");

      x.style.left = "-999em";
      x.style.opacity = "0";
      dash.style.opacity = "1";    
      wrapper.style.backgroundColor = "lightgrey";
  });

}

function hideForm(){
    var form = document.querySelector("#popup-form-faq");
    var x = document.querySelector(".inside-main");
    form.style.display = "none";
    x.style.opacity = 1;
    var wrapper = document.querySelector("#wrapper");
    wrapper.style.backgroundColor = "lightgrey";
}

	


