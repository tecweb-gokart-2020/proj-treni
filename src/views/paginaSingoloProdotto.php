<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . '../includes/resources.php';
use function PRODOTTO\getInfoFromProdotto;
use function CARRELLO\addToCart;

session_start();

if (!isset($_GET['codArticolo'])) {
    header("Location: prodotti.php");
}

if ($_POST["add"] == "add") {
    try {
        if (addToCart($_SESSION["cartID"], $_GET["codArticolo"], $_POST["quantita"])) {
            $aggiunto = "Articolo aggiunto al carrello";
        }
    } catch (Exception $e) {
        $aggiunto = $e->getMessage();
    }
}

$prodottoAttuale = $_GET['codArticolo'];
$info = getInfoFromProdotto($prodottoAttuale);
$pagetitle = $info['marca']." ".$info['codArticolo']." - Trenene";
$pagedescription = "Informazioni dettagliate sul prodotto ". $info['codArticolo'] .": comprendono marca, descrizione e prezzo";
include __DIR__ . DIRECTORY_SEPARATOR . "template/header.php";

$current_page = '<a class="linkPercorso" href="prodotti.php">prodotti</a>'." >> ".$info['marca']." ".$info['codArticolo'];
include __DIR__ . DIRECTORY_SEPARATOR . "template/breadcrumb.php";

echo '<main id="contentSingoloProdotto">
    <div id="paginaSingoloProdotto">
    <h2>'.$info['marca'].' '.$prodottoAttuale.'</h2>
    <img src="imgs/'.$info['codArticolo'].'" alt=""/>
    <ul>
    <li>Categoria: '.$info['tipo'].'</li>
    <li><p>'.$info['descrizione'].'</p></li>';

// Le informazioni riportano uno sconto, va applicato
$inSconto = false;

if ($info['sconto']>0) {
    $inSconto = true;
}

if ($inSconto) {
    echo '<li>Si applica uno sconto del '.$info['sconto'].'%</li>';
}

echo '<li>Prezzo: ';

if ($inSconto) {
    echo '<del>';
}

echo $info['prezzo'].' €';

if ($inSconto) {
    echo '</del>';
}

echo '</li>';

if ($inSconto) {
    echo '<li>';
    echo $aux = $info['prezzo']-$info['sconto']/100*$info['prezzo'].' €</li>';
}

echo '</ul>';

echo '<form method="post">
            <div class="half-group"><label id="labelQuantita" for="quantita">Quantità</label>
            <input name="quantita" id="quantita" type="number" value="1" min="1" max="' . $info['quantita'] . '" step="1"/>
            </div>
            <button type="submit" id="add" name="add" value="add">Aggiungi al carrello</button>
      </form>';

if ($_SESSION["username"] == "admin") {
    echo '<a class="adminButton" href="adminEdit.php?codArticolo='. $info['codArticolo'] .'">Modifica</a>';
    echo '<a class="adminButton" href="adminDelete.php?codArticolo='. $info['codArticolo'] .'">Elimina</a>';
}

echo '</div>';

if ($aggiunto) {
    echo '<div id="confirm">'.$aggiunto.'</div>';
}

echo '</main>';

include __DIR__ . DIRECTORY_SEPARATOR . "template/footer.php";
