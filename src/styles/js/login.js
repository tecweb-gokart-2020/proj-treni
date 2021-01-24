var form;
var user;
var password;
var checkbox;

//riporta i messaggi di errore allo stato originale
function reset(input){
	if(input.getAttribute('aria-invalid') == 'true'){
		input.setAttribute("aria-invalid", "false");
		var idMsg = input.getAttribute('aria-errormessage');
		var messaggio = document.getElementById(idMsg);
		messaggio.style.visibility = "hidden";
	}
}

function displayError(input){
	input.setAttribute("aria-invalid", "true");
	//prende l'id del messaggio di errore dalla struttura via attributo aria
	var idMsg = input.getAttribute('aria-errormessage');
	var messaggio = document.getElementById(idMsg);
	//rende visibile e legge il messaggio di errore agli screen reader, poi imposta il focus
	messaggio.style.visibility = "visible";
	input.focus();
}

//gestisce la validazione del form di login
function validateLogin(){
	reset(user);
	reset(password);
	
	if(user.value == ""){
		displayError(user);
		return false;
	}	
	if(password.value == ""){
		displayError(password);
		return false;
	} 
}

function togglePassword(){
	//doppio controllo per coerenza
	if(checkbox.checked && password.type == "password"){
		password.type = "text";
	} else {
		password.type = "password";
	}
}

window.onload = function() {
	form = document.getElementById('formLogin');
	user = document.getElementById('loginUtente');
	password = document.getElementById('loginPassword');
	checkbox = document.getElementById('mostraPassword');

	checkbox.setAttribute("onclick", "togglePassword()");
	form.setAttribute("onsubmit", "return validateLogin()");
}	
