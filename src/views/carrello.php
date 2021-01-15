<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../includes/resources.php";
use function CARRELLO\getNewCarrello;
use function CARRELLO\getProdottiFromCarrello;
use function PRODOTTO\stampaProdotti;

session_start();
if(!isset($_SESSION["cartID"])) {
    $newcart = 2;// getNewCarrello();
    if($newcart) {
        $_SESSION["cartID"] = $newcart;
    } else {
        /* Caso davvero estremo, non dovrebbe mai capitare */
        error_log("Qualcosa è andato storto... impossibile inizializzare un nuovo carrello");
        die();
    }
}

// cartID correttamente impostato
$page_description = "Contenuto del carrello attualmente attivo";
$pagetitle = "carrello";
$carrello_link = "class=\"header_current_link\"";
$login_link= "href=\"login.php\"";
$area_personale_link = "href=\"info.php\"";
$notizie_link = "href=\"notizie.php\"";
$prodotti_link = "href=\"prodotti.php\"";
$servizi_link = "href=\"servizi.php\"";
$contatti_link = "href=\"contatti.php\"";
include "template/header.php";

$content = getProdottiFromCarrello($_SESSION["cartID"]);
if($content) {
    echo $content . PHP_EOL;
    echo "<h2>Il tuo carrello:</h2>" . PHP_EOL;
    echo "<ul id=\"cart\">" . PHP_EOL;
    stampaProdotti($content);
    echo "</ul>" . PHP_EOL;
}
else {
    echo "<h2>Il tuo carrello è vuoto al momento.</h2>" . PHP_EOL;
}

include "template/footer.php";
?>
