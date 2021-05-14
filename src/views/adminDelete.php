<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../includes/resources.php";
use function PRODOTTO\deleteProdotto;
use function PRODOTTO\getInfoFromProdotto;

session_start();
if(isset($_SESSION["username"])) {
    $pagetitle = "Elimina prodotto - Amministrazione";
    $pagedescription = "Interfaccia per la gestione dei prodotti del negozio";
    $js = '<script type="text/javascript" src="js/.js"></script>';
    include "template/header.php";

    $current_page = "Amministrazione >> Eliminazione prodotto";
    include "template/breadcrumb.php";

    if ($_GET['codArticolo']) {
        echo '<main id="content">';

        $info = getInfoFromProdotto($_GET['codArticolo']);

        if($info !== false) {
            if(isset($_GET['confirm'])) {
                if (deleteProdotto($_GET['codArticolo'])) {
                    echo '<h2>Prodotto eliminato con successo</h2><p>L\'articolo '. $_GET['codArticolo'] .' è stato eliminato con successo</p>';
                } else {
                    echo '<h2>Impossibile eliminare il prodotto</h2>';
                }
            } else {
                echo '<h2>Eliminazione '. $_GET['codArticolo'] .'</h2>';
                echo '<p>Se si è sicuri è possibile ';
                echo '<a id="link-conferma" href="adminDelete.php?codArticolo='. $_GET['codArticolo'] .'&confirm=true">Procedere con l\'eliminazione dell\'articolo</a></p>';
            }
        } else {
            echo '<h2>404</h2><p class="errore">Prodotto non troavto</p>';
        }

        echo '</main>';
    }
    include 'template/footer.php';
}
?>