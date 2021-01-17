<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../includes/resources.php';
use function ACCOUNT\getCartFromAccount;
use function CARRELLO\getNewCarrello;

session_start();
// debug
$_SESSION["username"] = "user";
if(isset($_SESSION["username"])) {
    $_SESSION["cartID"] = getCartFromAccount($_SESSION["username"]);
}
else {
    $_SESSION["cartID"] = getNewCarrello();
    if(!$_SESSION["cartID"]) {
        error_log("Qualcosa è andato storto... nuovo carrello impossibile da creare");
        die();
    }
}

$pagetitle = "Trenogheno - Home";
$pagedescription = "Pagina Home di trenogheno.it";

include __DIR__ . DIRECTORY_SEPARATOR . "template/header.php";

echo '<body>
    <div id="chiSiamo">
        <h2>CHI SIAMO</h2>
        <p><strong>TrenoGheno</strong> è una piccola azienda nata nel 1999 specializzata 
		nel settore del modellismo ferroviario</p>
    </div>
    <div id="servizi">
        <h2>I NOSTRI SERVIZI</h2>
        <ul>
            <li>Vendita di modelli ferroviari</li>
            <li>Ricambi</li>
            <li>Cataloghi</li>
			<li>Materiali ed 
			informazioni per la costruzione di plastici</li>
        </ul>
    </div>
    <div id="news">
        <h2>NOVITÀ</h2>';
//mettere immagini prodotti con flag(da aggiungere) novità

echo '</div>
    <div id="prodottiInHome">
	<h2>I NOSTRI PRODOTTI</h2>
        <a href="prodotti.html">Cerca nel catalogo</a>
    </div>

</body>';
include __DIR__ . DIRECTORY_SEPARATOR . "template/footer.php";
?>
