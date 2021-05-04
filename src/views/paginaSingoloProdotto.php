<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../includes/resources.php';
use function PRODOTTO\getInfoFromProdotto;
use function CARRELLO\addToCart;

session_start();

if(!isset($_GET['codArticolo'])){
    header("Location: prodotti.php");
}

if($_POST["add"] == "add") {
	try{
		if(addToCart($_SESSION["cartID"], $_GET["codArticolo"], $_POST["quantita"])){
			$aggiunto = "Articolo aggiunto al carrello";
		}
	} catch(Exception $e) {
		$aggiunto = $e->getMessage();
	}
}

$prodottoAttuale = $_GET['codArticolo'];
$info=getInfoFromProdotto($prodottoAttuale);
$pagetitle = $info['marca']." ".$info['codArticolo']." - Trenene";
$pagedescription = "Pagina".$info['marca']." ".$listaProdotti[$index]." di trenene.it";
include __DIR__ . DIRECTORY_SEPARATOR . "template/header.php";
    
$current_page = '<a href="prodotti.php">prodotti</a>'." >> ".$info['marca']." ".$info['codArticolo'];
include __DIR__ . DIRECTORY_SEPARATOR . "template/breadcrumb.php";
    
echo '<main id="contentSingoloProdotto">
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
echo '<form method="post">
            <label id="labelQuantita" for="quantita">Quantità</label>
            <input name="quantita" id="quantita" type="number" value="1" min="0" max="'. $info['quantita'] .'" step="1"/>
        <button type="submit" id="add" name="add" value="add">Aggiungi al carrello</button>
    </form>';
    	if($_SESSION["username"] == "admin") {
		echo '<a href="adminEdit.php?codArticolo='. $info['codArticolo'] .'">Modifica</a>';
	}
    echo '</div>';
if($aggiunto) {
    echo '<div id="confirm">'.$aggiunto.'</div>';
}
echo '</main>';

include __DIR__ . DIRECTORY_SEPARATOR . "template/footer.php";

?>
