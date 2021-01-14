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

?>
