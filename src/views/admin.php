<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../includes/resources.php";
use DB\DBAccess;

session_start();
if(isset($_SESSION["username"])) {
    $tag_info = "";
    $pagetitle = "Amministrazione";
    $pagedescription = "Area dove è possibile gestire i prodotti del negozio";
    $js = '<script type="text/javascript" src="js/.js"></script>';
    include "template/header.php";

    $current_page = " >> Amministrazione";
    include "template/breadcrumb.php";
    echo '<main id="content">
    <form id="insProd" name="insProd" action="admin/adminAdd.php" method="post" novalidate="true">
        <fieldset><legend>Inserimento</legend>
            <label>Codice articolo
                <input type="number" name="codice" required="true">
            </label>
            <label>Tipo
                <select name="tipo" required="true">
                    <option value="locomotiva">Locomotiva</option>
                    <option value="carrozza">Carrozza</option>
                    <option value="carro">Carro</option>
                    <option value="accessorio">Accessorio</option>
                    <option value="binari">Binari</option>
                </select>
            </label>
            <label>Descrizione
                <input type="text" name="descrizione" maxlength="100">
            </label>
            <label>Scala
                <input type="text" name="scala" maxlength="3">
            </label>
            <label>Amministrazione
                <input type="text" name="amministrazione" maxlength="3">
            </label>
            <label>Prezzo
                <input type="number" name="prezzo" required="true">
            </label>
            <label>Sconto
                <input type="number" name="sconto">
            </label>
            <label>Quantità
                <input type="number" name="quantita" min="1">
            </label>
            <label>Immagine
                <input type="file" name="immagine">
            </label>
            <input type="reset" value="Reset">
            <input type="submit" value="Inserisci">
        </fieldset>
    </form>';
    include 'template/footer.php';
}
?>