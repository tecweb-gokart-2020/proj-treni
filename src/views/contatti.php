<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../includes/resources.php';
$pagetitle = "Trenogheno - Contatti";
$pagedescription = "Pagina Contatti di trenogheno.it";

$tag_contatti = '<span class="current_link">';
include __DIR__ . DIRECTORY_SEPARATOR . "template/header.php";

$current_page = "contatti";
include "template/breadcrumb.php";

echo '<main name="content">' . PHP_EOL;
echo '<p><strong>TrenoGheno</strong> è una piccola azienda nata nel 1999 tra Pordenone e Portogruaro (VE), specializzata nel settore del modellismo ferroviario.</p>
        <p>Anche se giovane, vanta del personale con una esperienza e conoscenza del settore che le permette di soddisfare quasi tutti i desideri degli appassionati fermodellisti. </p>
        <p>Può offrire:</p>
        <ul>
            <li>Cataloghi</li>
            <li>Modelli</li>
            <li>Ricambi</li>
            <li>Materiali e informazioni per la costruzione di plastici e diorami di alta qualità</li>
        </ul>
        <p>Per la consegna dei prodotti si avvale di Poste Italiane o di corrieri privati</p>
    </div>
    <div id="contenutoContatti">
        <p>Contatti:</p>
        <ul>
            <li><strong><span xml:lang="en">MAIL</span></strong>: <a href="mailto:info@trenogheno.it">info@trenogheno.it</a></li>
            <li><strong><span xml:lang="en">MOBILE</span></strong>: +39 348 443 19 33</li>
            <li><strong>FAX</strong>: +39 0434 572 865</li>
        </ul>';
echo '</main>';
include __DIR__ . DIRECTORY_SEPARATOR . "template/footer.php";
?>
