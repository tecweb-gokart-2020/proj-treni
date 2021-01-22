<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../includes/resources.php";
use DB\DBAccess;
use function ACCOUNT\register;
use function UTILITIES\cleanUp;
use function CARRELLO\getNewCarrello;
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST"){
	$email = $_POST["email"];
	$nomeUtente = $_POST["nomeUtente"];
	$password = $_POST["password"];
	$rePassword = $_POST["password2"];

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
		// perdonami Ranzato perchè ho peccato
		if($rePassword == $password){
			// var_dump($email);
			// var_dump($nomeUtente);
			// var_dump($password);
			// var_dump($_SESSION["cartID"]);
			$newUser = register($email, $nomeUtente, $password, $_SESSION["cartID"]);
		} else throw new Exception("le password non coincidono");

	} catch (Exception $e) {
		$error = $e->getMessage();
	}
	if(!$error and $newUser){
		//mostrare conferma registrazione
		$pagetitle = "trenene - Registrazione";
		$pagedescription = "Conferma della registrazione avvenuta su trenene.it";
		include __DIR__ . DIRECTORY_SEPARATOR. "template/header.php";
		echo '<main id="content"><div class="container" id="confermaRegistr"><p><em>Registrazione avvenuta con successo</em></p>
		<p>' . $newUser . ', benvenuto su trenene.it!</p></div>
		<div id="registerToHome">ora puoi <a href="login.php">accedere al sito</a></div></main>';
		include __DIR__ . DIRECTORY_SEPARATOR. "template/footer.php";
	}
	else {
		$_SESSION["registerErr"] = $error;
		header("Location: register.php");
		exit();
	} 
}
?>
