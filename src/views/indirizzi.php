<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../includes/resources.php";
use function ACCOUNT\getAddressesFromAccount;
use function INDIRIZZO\getInfoFromAddress;

function printAddress($addressID) {
    $addr = getInfoFromAddress($addressID);
    echo "<ul>" . PHP_EOL;
    echo "<li>indirizzo totale</li>" . PHP_EOL;
    echo "</ul>" . PHP_EOL;

}

session_start();
if(isset($_SESSION["username"])) {
    /* Se l'utente è autenticato mostrerà la pagina giusta, farà
     * invece un redirect alla home se non lo è (caso in cui l'utente
     * richiede la pagina direttamente da url, invece che dalla home
     * dopo il login) */

    $area_personale_link = "class=\"header_current_link\"";
    $notizie_link = "href=\"notizie.php\"";
    $prodotti_link = "href=\"prodotti.php\"";
    $servizi_link = "href=\"servizi.php\"";
    $contatti_link = "href=\"contatti.php\"";
    include "template/header.php";

    $info_personali_link = "href=\"info.php\"";
    $ordini_link = "href=\"ordini.php\"";
    $indirizzi_link = "class=\"active_link\"";
    include "template/ap_navbar.php";

    $addresses = getAddressesFromAccount($_SESSION["username"]);
    echo "<ul>" . PHP_EOL;
    foreach($addresses as &$address) {
        printAddress($address);
    }
    echo "</ul>" . PHP_EOL;
        
    include "template/footer.php";
}
else {
    echo "username risulta non settato :(";
    // header("Location: www.google.it", TRUE, 401);
    // exit();
}
?>
