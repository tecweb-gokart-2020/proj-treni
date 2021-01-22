<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../includes/resources.php";
use function CARRELLO\getNewCarrello;
use function CARRELLO\getProdottiFromCarrello;
use function PRODOTTO\stampaProdotti;

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
$pagedescription = "Contenuto del carrello";
$pagetitle = "carrello";
$tag_cart = "";
include "template/header.php";

$current_page = "carrello";
include "template/breadcrumb.php";

echo '<main id="content">' . PHP_EOL;
$prodotti = getProdottiFromCarrello($_SESSION["cartID"]);
if($prodotti) {
    echo "<h2>Il tuo carrello:</h2>" . PHP_EOL;
    echo "<ul id=\"cart\">" . PHP_EOL;
    foreach($prodotti as $prodotto){
	    stampaProdotti(array($prodotto["codArticolo"]), true, $prodotto["quantita"]);
    }
    echo "</ul>" . PHP_EOL;
    echo '<form action="checkout.php" method="post"><button type="submit">Procedi all\'ordine</button></form>';
}
else {
    echo "<h2>Il tuo carrello è vuoto al momento.</h2>" . PHP_EOL;
}

echo '</main>';
include "template/footer.php";
?>
