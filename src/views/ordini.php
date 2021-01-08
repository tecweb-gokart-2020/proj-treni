<?php
require_once(__DIR__ . DIRECTORY_SEPARATOR . "../includes/resources.php");
use function ACCOUNT\getOrdersFromAccount;
use function ACCOUNT\getTotalFromOrder;
use function ACCOUNT\getDateFromOrder;

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
    $ordini_link = "class=\"active_link\"";
    $indirizzi_link = "href=\"indirizzi.php\"";
    include "template/ap_navbar.php";

    $user = $_SESSION["username"];
    $orders = getOrdersFromAccount($user);
    $count = count($orders);
    
    echo "<h2>Al momento hai $count ordini effettuati:</h2>" . PHP_EOL; 
    for($i = 0; i < $count; $i += 1) {
        $total = getTotalFromOrder($orders[$i]);
        $date = getDateFromOrder($orders[$i]);
        echo "<h3>Ordine $i:</h3>"
            . PHP_EOL .
            "Totale: $total " . HTML_EOL . " Data: $date " . HTML_EOL;
    }
    
    include "template/footer.php";
}
else {
    echo "username risulta non settato :(";
    // header("Location: www.google.it", TRUE, 401);
    // exit();
}
?>
