<?php
require_once(__DIR__ . DIRECTORY_SEPARATOR . "../includes/resources.php");
use DB\DBAccess;
use function ACCOUNT\login;
use function UTILILTIES\cleanUp;
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST"){
	$utente = $_POST["nomeUtente"];
	$password = $_POST["password"];

	//controlli e sanificazioni
	$utente = cleanUp($utente);
	$password = cleanUp($password);

	//login
	$nome = login($utente, $password); 
	if($nome){
		$_SESSION["username"] = $nome;
		header("Location: home.php"); //redirect a homepage. Ma se volessi tornare dove ero prima? Complicato...			
		exit();
	} else {
		$_SESSION["loginErr"] = "Utente o password non corretti";
		header("Location: login.php");  
		exit();
	}
}
else header("Location: home.php"); //se è arrivato per vie traverse, rimandiamolo alla home
?>
