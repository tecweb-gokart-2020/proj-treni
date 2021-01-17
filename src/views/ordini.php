<?php
session_start();
if(isset($_SESSION["username"])) {
    /* Se l'utente è autenticato mostrerà la pagina giusta, farà
     * invece un redirect alla home se non lo è (caso in cui l'utente
     * richiede la pagina direttamente da url, invece che dalla home
     * dopo il login) */

    $tag_ordini = "<p>";
    include "template/header.php";

    $info_personali_link = "href=\"info.php\"";
    $ordini_link = "class=\"active_link\"";
    $indirizzi_link = "href=\"indirizzi.php\"";
    include "template/ap_navbar.php";

    echo "MAIN CONTENT";
    
    include "template/footer.php";
}
else {
    /* Se l'utente non è impostato -> l'utente deve loggarsi ->
     * redirect alla pagina di login */
    $host  = $_SERVER['HTTP_HOST'];
    $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $extra = 'login.php';
    header("Location: http://$host$uri/$extra");
    exit();
}
?>
