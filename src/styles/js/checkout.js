var nome;
var cognome;
var via;
var civico;
var citta;
var provincia;
var cap;
var stato;
var telefono;

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

//gestisce la validazione del form di inserimento indirizzo
function validateAddress(){
	var nomeRegex = /^[a-z]+( [a-z]+)*$/i;
	var cognomeRegex = /^[a-z]+(( |\'|\-)[a-z]+)*$/i;
	var viaRegex = /^[a-z]+ [\w]+\.?(( |\-)[\w]+\.?)*$/i;
	var civicoRegex = /^[\w \.\-\\]+$/;
	var cittaRegex = /^[a-z]+( [a-z]+)*( [a-z]+\'[a-z]+)*( [a-z]+)*$/i;
	var provinciaRegex = /^[a-z]+(( |\-)[a-z]+)*$/i;
	var capRegex = /^\d{5}$/;
	var statoRegex = /^[a-z]{2,}( [a-z]+)*( [a-z]+\'[a-z]+)*( [a-z]+)*$/i;
	var telefonoRegex = /^((00|\+)39)?(0\d{5,9}|3\d{9})$/;

	reset(nome);
	reset(cognome);
	reset(via);
	reset(civico);
	reset(citta);
	reset(provincia);
	reset(cap);
	reset(stato);
	reset(telefono);

	//gestisce gli errori uno alla volta, dall'alto al basso, se no lo screen reader non legge bene
	if(nome.value == "" || !(nome.value.trim()).match(nomeRegex)){
		displayError(nome);
		return false;
	}
	if(cognome.value == "" || !(cognome.value.trim()).match(cognomeRegex)){
		displayError(cognome);
		return false;	
	}	
	if (via.value == "" || !(via.value.trim()).match(viaRegex)){
		displayError(via);
		return false;
	}
	if(civico.value == "" || !(civico.value.trim()).match(civicoRegex)){
		displayError(civico);
		return false;
	}
	if(citta.value == "" || !(citta.value.trim()).match(cittaRegex)){
		displayError(citta);
		return false;
	}
	if(provincia.value == "" || !(provincia.value.trim()).match(provinciaRegex)){
		displayError(provincia);
		return false;
	}
	if(cap.value == "" || !(cap.value.trim()).match(capRegex)){
		displayError(cap);
		return false;
	}
	if(stato.value == "" || !(stato.value.trim()).match(statoRegex)){
		displayError(stato);
		return false;
	}
	if(telefono.value != ""){ 
		var numTel = telefono.value.replace(/\s+/g, "");
		console.log(numTel);
		if(!numTel.match(telefonoRegex)){
			displayError(telefono);
			return false;
		}
	}
}

window.onload = function () {
	form = document.getElementById('formCheckout');
	nome = document.getElementById('nome');
	cognome = document.getElementById('cognome');
	via = document.getElementById('via');
	civico = document.getElementById('civico');
	citta = document.getElementById('citta');
	provincia = document.getElementById('provincia');
	cap = document.getElementById('cap');
	stato = document.getElementById('stato');
	telefono = document.getElementById('telefono');

	form.setAttribute("onsubmit", "return validateAddress()");
}