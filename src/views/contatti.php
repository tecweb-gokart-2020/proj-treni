<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . '../includes/resources.php';
$pagetitle = "Contatti - Trenene";
$pagedescription = "Pagina Contatti di trenene.it";

$tag_contatti = '<span class="current_link">';
include __DIR__ . DIRECTORY_SEPARATOR . "template/header.php";

$current_page = "contatti";
include "template/breadcrumb.php";

echo '<main id="content">' . PHP_EOL;
echo '<p><strong>Trenene</strong> è una piccola azienda nata nel 1999 tra l\'arcella e la stanga (PD), specializzata nel settore del modellismo ferroviario.</p>
        <p>Anche se giovane, vanta del personale con una esperienza e conoscenza del settore che le permette di soddisfare quasi tutti i desideri degli appassionati fermodellisti. </p>
        <p>Può offrire:</p>
        <ul>
            <li>Cataloghi</li>
            <li>Modelli</li>
            <li>Ricambi</li>
            <li>Materiali e informazioni per la costruzione di plastici e diorami di alta qualità</li>
        </ul>
        <p>Per la consegna dei prodotti si avvale di Poste Italiane</p>
    <div id="contenutoContatti">
        <p>Contatti:</p>
        <ul>
            <li><strong><span xml:lang="en" lang="en">MAIL</span></strong>: <a href="mailto:info@trenene.it">info@trenene.it</a></li>
            <li><strong><span xml:lang="en" lang="en">MOBILE</span></strong>: 555 1234 555</li>
	</ul>
	</div>
	<div id="indirizzo">
	<address>
		<strong>Vieni a trovarci!</strong> 
		<ul>
			<li> Esposizione in via fasulla, 123 - Padova (ITA)</li>
		</ul>
	</address>
	</div>';
echo '</main>';
include __DIR__ . DIRECTORY_SEPARATOR . "template/footer.php";
