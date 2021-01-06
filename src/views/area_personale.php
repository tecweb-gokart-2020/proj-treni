<?php
if(isset($_SESSION["username"])) {
    /* Se l'utente è autenticato mostrerà la pagina giusta, farà
     * invece un redirect alla home se non lo è (caso in cui l'utente
     * richiede la pagina direttamente da url, invece che dalla home
     * dopo il login) */
    
    include "template/ap_navbar.html";
    
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
    header("Location: ../index.php", TRUE, 401);
    exit();
}
?>
