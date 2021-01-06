<?php
if(isset($_SESSION["username"])) {
    /* Se l'utente è autenticato mostrerà la pagina giusta, farà
     * invece un redirect alla home se non lo è (caso in cui l'utente
     * richiede la pagina direttamente da url, invece che dalla home
     * dopo il login) */
    include __DIR__ . DIRECTORY_SEPARATOR . "templates/header.php";
    $nav_dir = "res/ap_navbar.html";
    $nav_file = fopen($nav_dir, "r");
    $nav = fread($nav_file, filesize($nav_dir));
    if(isset($_GET["addresses"])) {
        // echo $nav;
        echo "INDIRIZZI";
    }
    if(isset($_GET["orders"])) {
        // echo $nav;
        echo "ORDINI";
    }
    include __DIR__ . DIRECTORY_SEPARATOR . "templates/footer.php";
}
else {
    header("Location: ../index.php", TRUE, 401);
    exit();
}
?>
