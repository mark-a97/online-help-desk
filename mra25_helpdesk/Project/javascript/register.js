
window.addEventListener("load", init);

function init(){

	var btnRegister = document.querySelector("#btnRegister");
    btnRegister.addEventListener("click", pageRegister);

    var goBack = document.querySelector("#btnBack");
    goBack.addEventListener("click", btnBack);

    var eye = document.querySelector("#show-pass");
    var password = document.querySelector("#input-pass");
    var confirmPass = document.querySelector("#input-confirm");
    eye.addEventListener('click', function() {

        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        const typeb = confirmPass.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        confirmPass.setAttribute('type', typeb);
        this.classList.toggle('fa-eye-slash');
    });

}


function pageRegister(e) {
    var errors = false;
    var x = document.querySelectorAll(".auth-input");
    for (var i = 0; i < x.length; i++) {  
        if(x[i].value.trim() === "" && x[i] != document.querySelector("#mobileInput")){
            x[i].style.borderColor = "#f74e4e";
            errors = true;
            e.preventDefault();
        }
        else {
            x[i].style.borderColor = "#ccc";
        }
    }
}

function btnBack(e) {
    e.preventDefault();
    window.open('login.php', '_self');
}


	


