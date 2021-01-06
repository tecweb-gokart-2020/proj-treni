<?php
if(isset($_SESSION["username"])) {
    /* Se l'utente è autenticato mostrerà la pagina giusta, farà
     * invece un redirect alla home se non lo è (caso in cui l'utente
     * richiede la pagina direttamente da url, invece che dalla home
     * dopo il login) */
    
    $nav_dir "template/ap_navbar.html";
    $nav_file = fopen($nav_dir, "r");
    $nav = fread($nav_file, filesize($nav_dir));
    echo $nav;
    echo "Madonna beata";
    
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
    header("Location: www.google.it", TRUE, 401);
    exit();
}
?>
