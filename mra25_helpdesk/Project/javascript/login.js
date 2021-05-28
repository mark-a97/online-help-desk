window.addEventListener("load", init);

function init(){
	
	//MAIN PAGE//

	var btnRegister = document.querySelector("#btnRegister");
    btnRegister.addEventListener("click", pageRegister);

	var btnLogin = document.querySelector("#btnLogin");
    btnLogin.addEventListener("click", loginUser);
	
}

function loginUser(e) {
    var x = document.querySelectorAll(".auth-input");
    for (var i = 0; i < x.length; i++) {  
        if(x[i].value.trim() === ""){
            x[i].style.borderColor = "#f74e4e";
            e.preventDefault();
        }
        else {
            x[i].style.borderColor = "#ccc";
        }
    }
}

function pageRegister(e) {
    e.preventDefault();
    window.open('register.php', '_self');
}
