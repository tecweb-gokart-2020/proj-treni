var form;
var email;
var user;
var password;
var password2;
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

//gestisce la validazione del form di registrazione
function validateRegister(){
	var emailRegex = /^[\w!#\$%&'\*\+\/=\?\^`\{\|\}~]+((.|-)[\w!#\$%&'\*\+\/=\?\^`\{\|\}~]+)*@[\w]+((.|-)\w)*\.(\w)+$/;
	var userRegex = /^\w{3,}$/;
	var passwordRegex = /^[^<>\/\\\,\.:;\'\s]+$/;

	reset(email);
	reset(user);
	reset(password);
	reset(password2);

	//gestisce gli errori uno alla volta, dall'alto al basso, se no lo screen reader non legge bene
	if(email.value == "" || !email.value.match(emailRegex)){
		displayError(email);
		return false;
	}
	if(user.value == "" || !user.value.match(userRegex)){
		displayError(user);
		return false;	
	}	
	if (password.value == "" || !password.value.match(passwordRegex)){
		displayError(password);
		return false;
	}
	if(password.value != password2.value){
		displayError(password2);
		return false;
	}	
}

function togglePassword(){
	//doppio controllo per coerenza
	if(checkbox.checked && password.type == "password"){
		password.type = "text";
		password2.type = "text";
	} else {
		password.type = "password";
		password2.type = "password";
	}
}

form = document.getElementById('formRegistr');
email = document.getElementById('registrEmail');
user = document.getElementById('registrUtente');
password = document.getElementById('registrPassword');
password2 = document.getElementById('registrPassword2');
checkbox = document.getElementById('mostraPassword');

checkbox.setAttribute("onclick", "togglePassword()");
form.setAttribute("onsubmit", "return validateRegister()");
