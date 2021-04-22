<?php

use function PRODOTTO\getInfoFromProdotto;

session_start();
if($_SESSION["username"] == "admin") {
    $prodotto = getInfoFromProdotto($_GET["codArticolo"]);
    if($prodotto) {
        echo '<form id="modProd" name="modProd" action=".php" method="post" novalidate="true">
        <fieldset><legend>Modifica'. $prodotto["codArticolo"] .'</legend>
            <label>Tipo
                <select name="tipo" >
                    <option value="locomotiva"'. ($prodotto["tipo"] == "locomotiva" ? 'selected="selected"' : "") .'>Locomotiva</option>
                    <option value="carrozza"'. ($prodotto["tipo"] == "carrozza" ? 'selected="selected"' : "") .'>Carrozza</option>
                    <option value="carro"'. ($prodotto["tipo"] == "carro" ? 'selected="selected"' : "") .'>Carro</option>
                    <option value="accessorio"'. ($prodotto["tipo"] == "accessorio" ? 'selected="selected"' : "") .'>Accessorio</option>
                    <option value="binario"'. ($prodotto["tipo"] == "binario" ? 'selected="selected"' : "") .'>Binari</option>
                </select>
            </label>
            <label>Descrizione
                <input type="text" name="descrizione" value="'. $prodotto["descrizione"].'" maxlength="100">
            </label>
            <label>Scala
                <input type="text" name="scala" value="'. $prodotto["scala"].'" maxlength="3">
            </label>
            <label>Amministrazione
                <input type="text" name="amministrazione" value="'. $prodotto["amministrazione"].'" maxlength="3">
            </label>
            <label>Prezzo
                <input type="number" name="prezzo" value="'. $prodotto["prezzo"].'">
            </label>
            <label>Sconto
                <input type="number" name="sconto" value="'. $prodotto["sconto"].'">
            </label>
            <label>Quantità
                <input type="number" name="quantita" value="'. $prodotto["quantita"].'">
            </label>
            <label>Novità
                <input type="checkbox" name="novita" value="1">
            </label>
            <label>Immagine
            <input type="file" name="immagine">
            </label>
            <input type="reset" value="Reset">
            <input type="submit" value="Elimina">
            <input type="submit" value="Modifica">
        </fieldset>
    </form>';
    } else {
        /* Il codice del prodotto selezionato non esiste, decidere come comportarsi */
    }
}
?>