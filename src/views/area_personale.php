<?php
// if(isset($_SESSION["username"])) {
    /* Se l'utente è autenticato mostrerà la pagina giusta, farà
     * invece un redirect alla home se non lo è (caso in cui l'utente
     * richiede la pagina direttamente da url, invece che dalla home
     * dopo il login) */
$area_personale_link = "";
$notizie_link = "notizie.php";
$prodotti_link = "prodotti.php";
$servizi_link = "servizi.php";
$contatti_link = "contatti.php";
    include __DIR__ . DIRECTORY_SEPARATOR . "template/header.php";
// $nav_dir = "res/ap_navbar.html";
// $nav_file = fopen($nav_dir, "r");
// $nav = fread($nav_file, filesize($nav_dir));
    if(isset($_GET["addr"])) {
        // echo $nav;
        echo PHP_EOL . "<main> INDIRIZZI </main>" . PHP_EOL;
    }
    else if(isset($_GET["ord"])) {
        // echo $nav;
        echo PHP_EOL . "<main> ORDINI </main>" . PHP_EOL;
    }
    else {
        echo PHP_EOL . "<main> INFO PERSONALI </main>" . PHP_EOL;
    }
    include __DIR__ . DIRECTORY_SEPARATOR . "template/footer.php";
// }
// else {
//     header("Location: ../index.php", TRUE, 401);
//     exit();
// }
?>
