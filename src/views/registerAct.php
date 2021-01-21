<?php
require_once(__DIR__ . DIRECTORY_SEPARATOR . "../includes/resources.php");
use DB\DBAccess;
use function ACCOUNT\register;
use function UTILILTIES\cleanUp;
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST"){
	$email = $_POST["email"];
	$nomeUtente = $_POST["nomeUtente"];
	$password = $_POST["password"];

	//pulizia base
	$email = cleanUp($email);
	$nomeUtente = cleanUp($nomeUtente);
	$password = cleanUp($password);

	//controllo che esista un carrello, come richiesto dalla funzione
	if(!isset($_SESSION["cartID"]){
		$_SESSION["cartID"] = CARRELLO\getNewCarrello();
		if(!$_SESSION["cartID"]) {
		    error_log("Qualcosa è andato storto... nuovo carrello impossibile da creare");
		    echo "Errore del server nella gestione della richiesta, riprova più tardi.";
		    die();
		}
	}

	try{
		//registrazione
		//forse possibile che succedano cose strane coi carrelli, tipo uno condiviso fra più utenti, db permettendo
		$newUser = register($email, $nomeUtente, $password);				
		if(isset($newUser)){
			$_SESSION["username"] = $newUser;
			//mostrare conferma registrazione
			echo '<div class="container" id="confermaRegistr"><p><em>Registrazione avvenuta con successo</em></p>
			<p>' . $newUser . ', benvenuto su Trenogheno.it!</p></div>
			<div id="registerToHome"><a href="home.php">Vai al sito</a></div>'
		}		
	} catch(throwable $t){
		//c'è eccezione ma non riguarda la connessione, passarlo al form
		if(stristr($t, "Connection") == false){
			$_SESSION["registerErr"] = $t;
			header("location: register.php");
		} 
		//il problema è la connessione
		else echo "Errore del server nella gestione della richiesta, riprova più tardi.";
	}
}
?>