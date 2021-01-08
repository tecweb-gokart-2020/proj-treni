<?php
require_once(__DIR__ . DIRECTORY_SEPARATOR . "../includes/resources.php");
use DB\DBAccess;
use function ACCOUNT\getEmailOfAccount;

session_start();

if(isset($_SESSION["username"]) or true) {
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

    $info_personali_link = "class=\"active_link\"";
    $ordini_link = "href=\"ordini.php\"";
    $indirizzi_link = "href=\"indirizzi.php\"";
    include "template/ap_navbar.php";

    // debug
    $_SESSION["username"] = "user";
    $email = getEmailOfAccount($_SESSION["username"]);
    $user = $_SESSION["username"];
    echo "<ul><li>username: $user</li> <li>email: $email</li></ul>";
    
    include "template/footer.php";
}
else {
    echo "username risulta non settato :(";
    // header("Location: www.google.it", TRUE, 401);
    // exit();
}
?>
