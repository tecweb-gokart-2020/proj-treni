<?php
session_start();
if(isset($_SESSION["username"])) {
    /* Se l'utente è autenticato mostrerà la pagina giusta, farà
     * invece un redirect alla home se non lo è (caso in cui l'utente
     * richiede la pagina direttamente da url, invece che dalla home
     * dopo il login) */

    $area_personale_link = "";
    $notizie_link = "notizie.php";
    $prodotti_link = "prodotti.php";
    $servizi_link = "servizi.php";
    $contatti_link = "contatti.php";
    include "template/header.php";

    include "res/ap_navbar.html";
    
    if(isset($_GET["addr"])) {
        $main_content = "template/indirizzi.php";
    }
    else if(isset($_GET["ord"])) {
        $main_content = "template/ordini.php";
    }
    else {
        $main_content = "template/info.php";
    }
    include $main_content;
    include "template/footer.php";
}
else {
    echo "username risulta non settato :(";
    // header("Location: www.google.it", TRUE, 401);
    // exit();
}
?>
