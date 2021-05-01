<?php

use function PRODOTTO\getInfoFromProdotto;
use function PRODOTTO\insertProdotto;
use function UTILITIES\isValidID;

session_start();
if($_SESSION["username"] == "admin") {
    unset($err);
    $err = "";
    if(!isValidID($_POST["codArticolo"]))
        $err .= "codArticolo non valido ";
    if(getInfoFromProdotto($_POST["codArticolo"]) != null)
        $err .= "Articolo già presente";
    if($err != "") {
        $_SESSION["addError"] = $err;
        header("Location: admin.php");
        exit();
    } else {
        $prodotto = insertProdotto($_POST);
        $pagetitle = "Admin - nuovo prodotto";
        $pagedescription = "Inserimento di un nuovo articolo nel database";
        include "template/header.php";
        if($prodotto) {
            echo '<main id="content"><h1>Inserimento completato</h1><p>Inserimento andato a buon fine, è possibile vedere il nuovo prodotto nella
                     <a href="paginaSingoloProdotto.php?codArticolo=' . $_POST["codArticolo"] . '">pagina</a> corrispondente</p></main>';
        } else {
            echo '<main id="content"><h1>Inserimento errato</h1><p>Il prodotto non è stato inserito, ispezionare i log per capire cosa è successo</p></main>';
        }
    }
}
?>