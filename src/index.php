<?php

// unico file da includere con tutto il backend
require_once __DIR__ . DIRECTORY_SEPARATOR . "includes/resources.php";
use function ACCOUNT\getCartFromAccount;
use function CARRELLO\getNewCarrello;

// variabili riferite alla singola pagina
$pagetitle = "Homepage - Trenene";
$pagedescription = "Descrizione della homepage";

// per testare finchè non è completata la funzione di login
session_start();
$_SESSION["username"] = "user";
if (isset($_SESSION["username"])) {
    $_SESSION["cartID"] = getCartFromAccount($_SESSION["username"]);
} else {
    $_SESSION["cartID"] = getNewCarrello();
    if (!$_SESSION["cartID"]) {
        error_log("Qualcosa è andato storto... nuovo carrello impossibile da creare");
        die();
    }
}

// Esempio di inclusione delle viste header, corpo di index e footer
$area_personale_link = "href=\"views/info.php\"";
$carrello_link = "href=\"views/carrello.php\"";
$notizie_link = "href=\"views/notizie.php\"";
$prodotti_link = "href=\"views/prodotti.php\"";
$servizi_link = "href=\"views/servizi.php\"";
$contatti_link = "href=\"views/contatti.php\"";
include __DIR__ . DIRECTORY_SEPARATOR . "views/template/header.php";

include __DIR__ . DIRECTORY_SEPARATOR . "views/template/footer.php";
