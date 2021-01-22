<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../includes/resources.php";
use function CARRELLO\getNewCarrello;
use function CARRELLO\getProdottiFromCarrello;
use function PRODOTTO\getInfoFromProdotto;

function stampaProdotto($prodotto){
        $info=getInfoFromProdotto($prodotto["codArticolo"]);
        echo '<li><a href="paginaSingoloProdotto.php?codArticolo=' . $prodotto["codArticolo"] .
                                                                   '"><h2>'.$info['marca'].' '.
                                                                   $prodotto["codArticolo"].
                                                                   '</h2></a><img src="img/'
                                                                   .$prodotto["codArticolo"].
                                                                   '" alt=""/><ul><li>'.
                                                                   $info['tipo'].'</li>';
	echo '<li>';
        echo '<label for="quantita-'. $prodotto["codArticolo"] .'">Quantita</label>';
        echo '<input name="quantita-'. $prodotto["codArticolo"] .'" id="quantita-'. $prodotto["codArticolo"] .'" type="number" value="' . $prodotto["quantita"] . '" min="0" max="'.$info["quantita"].'" />';
	echo '</li>';
        if($info['sconto']!=""){
            echo '<li>Si applica uno sconto del '.$info['sconto'].'%</li>';
        }
        echo '<li>';
        if($info['sconto']!=""){
            echo '<del>';
        }
        echo $info['prezzo'];
        if($info['sconto']!=""){
            echo '</del>';
        }
        echo '</li>';
        if($info['sconto']!=""){
            echo '<li>';
            echo $aux=$info['prezzo']-$info['sconto']/100*$info['prezzo'];
            echo '</li>';
        } 
        echo '</ul></li>';
}

session_start();
//debug 
// $_SESSION["username"] = 'user';
// $_SESSION["cartID"] = 2;
if(!isset($_SESSION["cartID"])) {
    $newcart = getNewCarrello();
    if($newcart) {
        $_SESSION["cartID"] = $newcart;
    } else {
        /* Caso davvero estremo, non dovrebbe mai capitare */
        error_log("Qualcosa è andato storto... impossibile inizializzare un nuovo carrello");
        die();
    }
}
// cartID correttamente impostato
$pagedescription = "Contenuto del carrello";
$pagetitle = "carrello";
$tag_cart = "";
include "template/header.php";

$current_page = "carrello";
include "template/breadcrumb.php";

echo '<main id="content">' . PHP_EOL;
$prodotti = getProdottiFromCarrello($_SESSION["cartID"]);
if($prodotti) {
    echo '<h2>Il tuo carrello:</h2><form action="checkout.php" method="post">' . PHP_EOL;
    echo "<ul id=\"cart\">" . PHP_EOL;
    foreach($prodotti as $prodotto){
	    stampaProdotto($prodotto);
    }
    echo "</ul>" . PHP_EOL;
    echo '<button type="submit">Procedi all\'ordine</button></form>';
}
else {
    echo "<h2>Il tuo carrello è vuoto al momento.</h2>" . PHP_EOL;
}

echo '</main>';
include "template/footer.php";
?>
