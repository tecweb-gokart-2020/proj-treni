var min;
var max;
var form;
var err;

function reset() {
	err.innerHTML = "";	
	if(min.getAttribute('aria-invalid') == 'true')
		min.setAttribute("aria-invalid", "false");
	if(max.getAttribute('aria-invalid') == 'true')
		max.setAttribute("aria-invalid", "false");
}

function filtroOk() {
	reset();
	//controllo validità. Molto viene filtrato già dal campo stesso
	if(!min.value.match(/^\d*$/)){
		min.setAttribute("aria-invalid", "true");
		min.focus();
		err.innerHTML = 'Inserisci solo numeri interi positivi';
		return false;
	}
	if(!max.value.match(/^\d*$/)){
		max.setAttribute("aria-invalid", "true");
		max.focus();
		err.innerHTML = 'Inserisci solo numeri interi positivi';
		return false;
	}
	//quello che c'è (o non c'è) va bene, se ci sono entrambi i valori controlliamo min < max
	if(min.value != "" && max.value != ""){
		if (min.value > max.value) {
			min.focus();
			err.innerHTML = 'Il prezzo minimo deve essere maggiore di quello massimo';
			return false;
		}		
	}
}

min = document.getElementById('filtroPrezzoMin');
max = document.getElementById('filtroPrezzoMax');
form = document.getElementById('formFiltro');
err = document.getElementById('erroreFiltro');

form.setAttribute('onsubmit', 'return filtroOk()');