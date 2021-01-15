<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../includes/resources.php";
use function CARRELLO\getNewCarrello;
use function CARRELLO\getProdottiFromCarrello;

session_start();
if(!isset($_SESSION["cartID"])) {
    $newcart = getNewCarrello();
    if($newcart) {
        $_SESSION["cartID"] = $newcart;
    } else {
        /* Caso davvero estremo, non dovrebbe mai capitare */
        error_log("Qualcosa è andato storto... impossibile inizializzare un nuovo carrello");
        die();
    }
}

// cartID correttamente impostato
$area_personale_link = "href=\"info.php\"";
$notizie_link = "href=\"notizie.php\"";
$prodotti_link = "href=\"prodotti.php\"";
$servizi_link = "href=\"servizi.php\"";
$contatti_link = "href=\"contatti.php\"";
include "template/header.php";

$content = getProdottiFromCarrello($_SESSION["cartID"]);
if($content) {
    echo "</h2>Il tuo carrello:</h2>" . PHP_EOL;
    echo "<ul id=\"cart\">" . PHP_EOL;
    foreach($content as $prodotto) {
        echo "<li>" . PHP_EOL;
        // printProdotto($prodotto);
        echo "</li>" . PHP_EOL;
    }
    echo "</ul>";
}
else {
    echo "</h2>Il tuo carrello è vuoto al momento.</h2>" . PHP_EOL;
}

include "template/footer.php";
?>
