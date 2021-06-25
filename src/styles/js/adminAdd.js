var form;
var codice;
var prezzo;
var immagine;

//riporta i messaggi di errore allo stato originale
function reset(input){
	if(input.getAttribute('aria-invalid') == 'true'){
		input.setAttribute("aria-invalid", "false");
		var idMsg = input.getAttribute('aria-errormessage');
		var messaggio = document.getElementById(idMsg);
		messaggio.style.visibility = "hidden";
		messaggio.style.display = "none";
	}
}

function displayError(input){
	input.setAttribute("aria-invalid", "true");
	//prende l'id del messaggio di errore dalla struttura via attributo aria
	var idMsg = input.getAttribute('aria-errormessage');
	var messaggio = document.getElementById(idMsg);
	//rende visibile e legge il messaggio di errore agli screen reader, poi imposta il focus
	messaggio.style.visibility = "visible";
	messaggio.style.display = "block";
	input.focus();
}

//gestisce la validazione del form di registrazione
function validate(){
	reset(codice);
	reset(prezzo);
	reset(immagine);

	//gestisce gli errori uno alla volta, dall'alto al basso, se no lo screen reader non legge bene
	if(codice.value == ""){
		displayError(codice);
		return false;
	}
	if(prezzo.value == ""){
		displayError(prezzo);
		return false;	
	}	
	if(immagine.files.length == 0){
		displayError(immagine);
		return false;
	}
}

window.onload = function () {
	form = document.getElementById('insProd');
	codice = document.getElementById('insProdCod');
	prezzo = document.getElementById('insProdPrezzo');
	immagine = document.getElementById('insProdImg');

	form.setAttribute("onsubmit", "return validate()");
}
