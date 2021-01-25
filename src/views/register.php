<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../includes/resources.php";
$pagetitle = "trenene - Registrazione";
$pagedescription = "Registrazione al sito trenene.it";
$js = '<script type="text/javascript" src="js/register.js"></script>';
include 'template/header.php';

session_start();
if($_SESSION["username"]) {
	// se ci arriva per vie traverse va reindirizzato alla home
	header("Location: home.php");
	exit();
}

echo '<main id="content">
	<div id="registrContainer" class="container">
		<div class="container">
			<p><h1>Crea account</h1>Inserisci i dati per registrarti su trenene.it. I campi contrassegnati con * sono obbligatori.</p>

			<form id="formRegistr" name="registr" action="registerAct.php" method="post" novalidate="true" aria-live="assertive">
				<label>Email *</br>
						<input type="email" name="email" id="registrEmail" maxlength="100" autocomplete="on" aria-errormessage="errorEmail" aria-invalid="false" required />
					</label>
					<div id="errorEmail" class="errore" >Per favore inserisci un indirizzo email valido</div>
					<label>Nome Utente *<div>Minimo 3 fra lettere e numeri, niente simboli o spazi</div>
						<input type="text" name="nomeUtente" id="registrUtente" maxlength="20" aria-errormessage="errorUsername" aria-invalid="false" required/>
					</label>
					<div id="errorUsername" class="errore" >Per favore inserisci un nome utente valido</div>
					<label>Password * <div>Questi simboli /\,.:;\'>< non sono consentiti</div>
						<input type="password" name="password" id="registrPassword" maxlength="50" aria-errormessage="errorPassword" aria-invalid="false" required/>
					</label>
					<div id="errorPassword" class="errore" >Per favore inserisci una password valida</div>
					<label>Conferma password *</br>
						<input type="password" name="password2" id="registrPassword2" maxlength="50" aria-errormessage="errorPassword2" aria-invalid="false" required/>
					</label>
					<div id="errorPassword2" class="errore" >Le due password non coincidono</div>
					<label><input id="mostraPassword" type="checkbox">Mostra password</label>
                    <input type="submit" value="Registrati"/>
			</form>';

if(isset($_SESSION["registerErr"])){
    echo '<div class="errore visibile" aria-live="assertive">' . $_SESSION["registerErr"] . '</div>';
    unset($_SESSION["registerErr"]);
}
echo '<div id="RegistrToLogin" class="container">
				<p>Già registrato? <a href="login.php"><strong>Accedi!</strong></a></p>
			</div>	
		</div>
	</div></main>
<script type="text/javascript" src="' . __DIR__ . DIRECTORY_SEPARATOR . '../styles/js/register.js"></script>';

include 'template/footer.php';
?>
