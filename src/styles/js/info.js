var oldEmail;
var newEmail;
var reEmail;
var oldPassword;
var newPassword;
var rePassword;
var form;
var checkbox;
var editEmail;
var editPw;
var chi;

function togglePassword(){
	//doppio controllo per coerenza
	if(checkbox.checked && newPassword.type == "password"){
		oldPassword.type = 'text';
		newPassword.type = "text";
		rePassword.type = "text";
	} else {
		oldPassword.type = 'password';
		newPassword.type = "password";
		rePassword.type = "password";
	}
}

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

function validateNewInfo() {
	var emailRegex = /^[\w!#\$%&'\*\+\/=\?\^`\{\|\}~]+((.|-)[\w!#\$%&'\*\+\/=\?\^`\{\|\}~]+)*@[\w]+((.|-)\w)*\.(\w)+$/;
	var passwordRegex = /^[^<>\/\\\,\.:;\'\s]+$/;

	reset(oldEmail);
	reset(newEmail);
	reset(reEmail);
	reset(oldPassword);
	reset(newPassword);
	reset(rePassword);

	if (chi == 'email') {
		if(oldEmail.value == ""){
			displayError(oldEmail);
			return false;
		}
		if(newEmail.value == "" || !newEmail.value.match(emailRegex) || newEmail.value == oldEmail.value){
			displayError(newEmail);
			return false;
		}
		if(reEmail.value != newEmail.value){
			displayError(reEmail);
			return false;
		}
	} else {
		if(oldPassword.value == ""){
			displayError(oldPassword);
			return false;
		}
		if(newPassword.value == "" || !newPassword.value.match(passwordRegex) || newPassword.value == oldPassword.value){
			displayError(newPassword);
			return false;
		}
		if(rePassword.value != newPassword.value){
			displayError(rePassword);
			return false;
		}
	}
}

window.onload = function () {
	form = document.getElementById('form');
	oldEmail = document.getElementById('oldMail');
	newEmail = document.getElementById('newMail');
	reEmail = document.getElementById('reMail');
	oldPassword = document.getElementById('oldPassword');
	newPassword = document.getElementById('newPassword');
	rePassword = document.getElementById('rePassword');
	checkbox = document.getElementById('mostraPassword');
	editEmail = document.getElementById('editEmail');
	editPw = document.getElementById('editPw');

	checkbox.setAttribute("onclick", "togglePassword()");
	form.setAttribute("onsubmit", "return validateNewInfo()");
	editEmail.setAttribute("onclick", "chi = 'email'");
	editPw.setAttribute("onclick", "chi = 'pw'");
}