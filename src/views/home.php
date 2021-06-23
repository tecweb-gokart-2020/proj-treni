<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../includes/resources.php';
use function ACCOUNT\getCartFromAccount;
use function PRODOTTO\ultimeNovita;
use function PRODOTTO\getInfoFromProdotto;

session_start();
// debug

$pagetitle = "Home - Trenene";
$pagedescription = "Pagina Home di trenene.it";
$tag_home = "";
include __DIR__ . DIRECTORY_SEPARATOR . "template/header.php";

echo '<main id="content">' . PHP_EOL;
echo '<div id="chiSiamo">
        <h2>CHI SIAMO</h2>
        <p><strong>Trenene</strong> è una piccola azienda nata nel 1999 specializzata 
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
        <h2>NOVITÀ</h2>
        <div id="novitaContainer">';
$new = ultimeNovita();
foreach($new as $prodotto) {
	$info = getInfoFromProdotto($prodotto);
	echo '<figure class="imgNovitaContainer"><img class="imgNovita" src="imgs/'. $prodotto . '" alt="'. $info['marca'].' '.$prodotto.'">';
	echo '<figcaption><a href="paginaSingoloProdotto.php?codArticolo='.$info['codArticolo'].'" class="middle">'. 
                                                                      $info['marca'] .' '. 
                                                                      $info['codArticolo'].'</a></figcaption></figure>';
}

echo '  </div>
    </div>';
echo '</main>';

include __DIR__ . DIRECTORY_SEPARATOR . "template/footer.php";
?>
