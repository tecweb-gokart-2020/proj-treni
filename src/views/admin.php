<!--
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
-->
<main id="content">
    <form id="insProd" name="insProd" action=".php" method="post" novalidate="true">
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
                <input type="text" name="descr" maxlength="100">
            </label>
            <label>Scala
                <input type="text" name="scala" maxlength="3">
            </label>
            <label>Amministrazione
                <input type="text" name="ammin" maxlength="3">
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
            <label>Novità
                <input type="checkbox" name="novita" value="1">
            </label>
            <label>Immagine
            <input type="file" name="immagine">
            </label>
            <input type="reset" value="Reset">
            <input type="submit" value="Inserisci">
        </fieldset>
    </form>

    <form id="modProd" name="modProd" action=".php" method="post" novalidate="true">
        <fieldset><legend>Modifica</legend>
            <label>Codice articolo
                <input type="number" name="codice" required="true">
            </label>
            <!-- questo bottone potrebbe caricare i dati del prodotto col codice inserito -->
            <button type="button">Carica dati</button>
            <label>Tipo
                <!-- oppure invece di select se più facile da gestire
                <input  list="tipo">
                <datalist>
                    <option value="locomotiva">Locomotiva</option>
                    <option value="carrozza">Carrozza</option>
                    <option value="carro">Carro</option>
                    <option value="accessorio">Accessorio</option>
                    <option value="binari">Binari</option>
                </datalist> -->
                <select name="tipo">
                    <option value="locomotiva">Locomotiva</option>
                    <option value="carrozza">Carrozza</option>
                    <option value="carro">Carro</option>
                    <option value="accessorio">Accessorio</option>
                    <option value="binari">Binari</option>
                </select>
            </label>
            <label>Descrizione
                <input type="text" name="descr" maxlength="100">
            </label>
            <label>Scala
                <input type="text" name="scala" maxlength="3">
            </label>
            <label>Amministrazione
                <input type="text" name="ammin" maxlength="3">
            </label>
            <label>Prezzo
                <input type="number" name="prezzo">
            </label>
            <label>Sconto
                <input type="number" name="sconto">
            </label>
            <label>Quantità
                <input type="number" name="quantita">
            </label>
            <label>Novità
                <input type="checkbox" name="novita" value="1">
            </label>
            <label>Immagine
            <input type="file" name="immagine">
            </label>
            <input type="reset" value="Reset">
            <!-- se ricevesse questo il server dovrebbe eliminare l'elemento -->
            <input type="submit" value="Elimina">
            <!-- basta sovrascrivere i campi modificati -->
            <input type="submit" value="Modifica">
        </fieldset>
    </form>
</main>

<!--
include 'template/footer.php';
?> -->