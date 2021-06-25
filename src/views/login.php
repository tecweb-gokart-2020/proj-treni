<?php
session_start();

$js = '<script type="text/javascript" src="js/login.js"></script>';
$pagetitle = "Login - Trenene";
$pagedescription = "pagina di login per il sito trenene.it";
include __DIR__ . DIRECTORY_SEPARATOR . 'template/header.php';

echo '<main id="content">
<div id="loginContainer" class="container">
	<h1>Benvenuto!</h1><p>Accedi al tuo account</p>
	<form id="formLogin" name="login" action="loginAct.php" method="post" novalidate="novalidate" aria-live="assertive">
		<label> <strong>Nome utente o Email</strong>
			<input type="text" name="nomeUtente" id="loginUtente" maxlength="30"  autocomplete="on" aria-errormessage="errorUsername" aria-invalid="false" required />
		</label>
		<div id="errorUsername" class="errore" >Per favore inserisci nome utente o email</div>
		<label> <strong>Password</strong>
			<input type="password" name="password" id="loginPassword" maxlength="50" autocomplete="on" aria-errormessage="errorPassword" aria-invalid="false" required  />
		</label>
		<div id="errorPassword" class="errore" >Per favore inserisci la password</div>
		<div class="half-group"><label>Mostra password</label><input id="mostraPassword" type="checkbox"></div>
        <input type="submit" id="loginInvio" value="Accedi" >
	</form>
	<div id="loginToRegistr" class="container">
		<p>Prima volta sul sito? <a href="register.php"><strong>Registrati!</strong></a></p>
	</div>
</div>';

if (isset($_SESSION["loginErr"])) {
    echo '<div class="errore visibile" aria-live="assertive">' . $_SESSION["loginErr"] . '</div>';
    unset($_SESSION["loginErr"]);
}

echo '</main>';
include __DIR__ . DIRECTORY_SEPARATOR . 'template/footer.php';
?>
