<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../includes/resources.php";
use function CARRELLO\getNewCarrello;
session_start();
if(!isset($_SESSION["cartID"])) {
    $newcart = getNewCarrello();
    if($newcart) {
        $_SESSION["cartID"] = $newcart;
    } else {
        error_log("Qualcosa è andato storto... impossibile inizializzare un nuovo carrello");
        die();
    }
}
// cartID correttamente impostato
echo "l'id del tuo carrello è $_SESSION['cartID']"

$area_personale_link = "href=\"info.php\"";
$notizie_link = "href=\"notizie.php\"";
$prodotti_link = "href=\"prodotti.php\"";
$servizi_link = "href=\"servizi.php\"";
$contatti_link = "href=\"contatti.php\"";
include "template/header.php";

include "template/footer.php";
?>
