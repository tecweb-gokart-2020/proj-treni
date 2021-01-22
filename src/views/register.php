<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../includes/resources.php";
$pagetitle = "trenene - Registrazione";
$pagedescription = "Registrazione al sito trenene.it";
include 'template/header.php';

session_start();
if($_SESSION["username"]) {
	// se ci arriva per vie traverse va reindirizzato alla home
	header("Location: home.php");
	exit();
}

echo '<main id="contenuto">
	<div id="registrContainer" class="container">
		<div class="container">
			<p><h1>Crea account</h1>Inserisci i dati per registrarti su trenene.it. I campi contrassegnati con * sono obbligatori.</p>

			<form name="registr" action="registerAct.php" method="post">
				<label>Email *
					<input type="email" name="email" id="registrEmail" maxlength="100" autocomplete="on" required />
				</label>
				<label>Nome Utente * (Minimo 3 caratteri)<br/>
					<input type="text" name="nomeUtente" id="registrUtente" maxlength="20" required/>
				</label>
				<label>Password * (Minimo 10 caratteri)<br/>
					<input type="password" name="password" id="registrPassword" maxlength="10" required/>
				</label>
				<label>Conferma password *
					<input type="password" name="password2" id="registrPassword2" maxlength="10" required/>
				</label>
                    <input type="submit" value="Registrati"/>
			</form>';

if(isset($_SESSION["registerErr"])){
    echo '<span class="errore">' . $_SESSION["registerErr"] . '</span>';
    unset($_SESSION["registerErr"]);
}
echo '<div id="RegistrToLogin" class="container">
				<p>Già registrato? <a href="login.php"><strong>Accedi!</strong></a></p>
			</div>	
		</div>
	</div></main>';

include 'template/footer.php';
?>
