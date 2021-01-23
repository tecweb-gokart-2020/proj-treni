<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../includes/resources.php';
use function PRODOTTO\getInfoFromProdotto;
use function CARRELLO\addToCart;

session_start();
// debug
// $_SESSION["cartID"] = 2;
// $_POST["add"] = "add";
// $_GET['codArticolo'] = 60052;

if(!isset($_GET['codArticolo'])){
    // se non è selezionato un prodotto probabilmente vuole vedere
    // i prodotti
    header("Location: prodotti.php");
}

if($_POST["add"] == "add") {
	try{
		$aggiunto = addToCart($_SESSION["cartID"], $_GET["codArticolo"]);
	} catch(Exception $e) {
		$aggiunto = $e->getMessage();
	}
}

$prodottoAttuale = $_GET['codArticolo'];
$info=getInfoFromProdotto($prodottoAttuale);
$pagetitle = $info['marca']." ".$info['codArticolo']." - trenene";
$pagedescription = "Pagina".$info['marca']." ".$listaProdotti[$index]." di trenene.it";
include __DIR__ . DIRECTORY_SEPARATOR . "template/header.php";
    
echo '<main id="content">
    <div id="paginaSingoloProdotto">
    <h2>'.$info['marca'].' '.$prodottoAttuale.'</h2>
    <img src="imgs/'.$info['codArticolo'].'" alt=""/>
    <ul>
    <li>Categoria: '.$info['tipo'].'</li>
    <li><p>'.$info['descrizione'].'</p></li>';
if($info['sconto']!=""){echo '<li>Si applica uno sconto del '.$info['sconto'].'%</li>';}
echo '<li>Prezzo: '; if($info['sconto']!=""){echo '<del>';} echo $info['prezzo'].' €'; if($info['sconto']!=""){echo '</del>';} echo '</li>';
if($info['sconto']!=""){echo '<li>'; echo $aux=$info['prezzo']-$info['sconto']/100*$info['prezzo'].' €</li>
    </ul>';}
echo '<ul id="formAcquisto">
    <li>Prezzo: '.$aux.'</li>
    <li>Disponibili all\'acquisto: '.$info['quantita'].'</li>
    <form method="post">
        <button type="submit" id="add" name="add" value="add">Aggiungi al carrello</button>
    </form>
    </ul>
    </div>';
if($aggiunto) {
    echo '<div id="confirm">Articolo aggiunto al carrello</div>';
}
echo '</main>';

include __DIR__ . DIRECTORY_SEPARATOR . "template/footer.php";

?>
