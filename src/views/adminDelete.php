<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../includes/resources.php";
use DB\DBAccess;
use function PRODOTTO\deleteProdotto;
use function PRODOTTO\getInfoFromProdotto;
use function PRODOTTO\stampaProdotti;

session_start();
if(isset($_SESSION["username"])) {
    $tag_info = "";
    $pagetitle = "Elimina prodotto - Amministrazione";
    $pagedescription = "Interfaccia per la gestione dei prodotti del negozio";
    $js = '<script type="text/javascript" src="js/.js"></script>';
    include "template/header.php";

    $current_page = " >> Amministrazione";
    include "template/breadcrumb.php";

    if ($_GET['codArticolo']) {
        echo '<main id="content">';

        $info = getInfoFromProdotto($_GET['codArticolo']);

        print_r($info);

        if($info !== false) {
            if(isset($_GET['confirm'])) {
                if(deleteProdotto($_GET['codArticolo'])){
                    echo '<h2>Prodtto eliminato con successo</h2><p>L\'articolo '. $_GET['codArticolo'] .' è stato eliminato con successo</p>';
                } else {
                    echo '<h2>Impossibile eliminare il prodotto</h2>';
                }
            } else {
                echo '<h2>Eliminazione '. $_GET['codArticolo'] .'</h2>';
                echo '<a id="link-conferma" href="adminDelete.php?codArticolo='. $_GET['codArticolo'] .'&confirm=true">Procedere con l\'eliminazione dell\'articolo</a>';
            }
        } else {
            echo '<h2>404</h2><p class="errore">Prodotto non troavto</p>';
        }

        echo '</main>';
    }
    include 'template/footer.php';
}
?>