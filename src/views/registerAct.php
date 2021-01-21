<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../includes/resources.php";
use DB\DBAccess;
use function ACCOUNT\register;
use function UTILITIES\cleanUp;
use function CARRELLO\getNewCarrello;
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" or true){
	$email = $_POST["email"];
	$nomeUtente = $_POST["nomeUtente"];
	$password = $_POST["password"];

	//pulizia base
	$email = cleanUp($email);
	$nomeUtente = cleanUp($nomeUtente);
	$password = cleanUp($password);

	//controllo che esista un carrello, come richiesto dalla funzione
	if(!isset($_SESSION["cartID"])){
		$_SESSION["cartID"] = getNewCarrello();
		if(!$_SESSION["cartID"]) {
		    error_log("Qualcosa è andato storto... nuovo carrello impossibile da creare");
		    echo "Errore del server nella gestione della richiesta, riprova più tardi.";
		    die();
		}
	}

	try{
		$newUser = register($email, $nomeUtente, $password, $_SESSION["cartID"]);				
	} catch (Exception $e) {
		$error = $e->getMessage();
	}
	if(!$error){
		$_SESSION["username"] = $newUser;
		//mostrare conferma registrazione
		$pagetitle = "Trenogheno - Registrazione";
		$pagedescription = "Conferma della registrazione avvenuta su trenogheno.it";
		include __DIR__ . DIRECTORY_SEPARATOR. "template/header.php";
		echo '<main id="content"><div class="container" id="confermaRegistr"><p><em>Registrazione avvenuta con successo</em></p>
		<p>' . $newUser . ', benvenuto su Trenogheno.it!</p></div>
		<div id="registerToHome">ora puoi <a href="login.php">accedere al sito</a></div></main>';
		include __DIR__ . DIRECTORY_SEPARATOR. "template/footer.php";
	}
	else {
		$_SESSION["registerErr"] = $error;
		header("Location: register.php");
	} 
}
?>
