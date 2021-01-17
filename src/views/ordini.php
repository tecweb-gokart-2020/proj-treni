<?php
session_start();
if(isset($_SESSION["username"])) {
    /* Se l'utente è autenticato mostrerà la pagina giusta, farà
     * invece un redirect alla home se non lo è (caso in cui l'utente
     * richiede la pagina direttamente da url, invece che dalla home
     * dopo il login) */

    $tag_info = "<span class=\"current_link\">"
    include "template/header.php";

    $tag_ordini = "<span class=\"current_link\">"
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
