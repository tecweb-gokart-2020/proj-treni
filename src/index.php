<?php
// unico file da includere con tutto il backend
require_once __DIR__ . DIRECTORY_SEPARATOR . "includes/resources.php";

// variabili riferite alla singola pagina
$pagetitle = "Homepage";
$pagedescription = "Descrizione della homepage";

// per testare finchè non è completata la funzione di login
session_start();
$_SESSION["username"] = "user";
if(isset($_SESSION["username"])) {
    echo "sta volta si eh";
} else {
    echo "come no";
}

// Esempio di inclusione delle viste header, corpo di index e footer
$area_personale_link = "views/area_personale.php";
$notizie_link = "";
$prodotti_link = "";
$servizi_link = "";
$contatti_link = "";
include __DIR__ . DIRECTORY_SEPARATOR . "views/template/header.php";
include __DIR__ . DIRECTORY_SEPARATOR . "views/template/footer.php";
?>
