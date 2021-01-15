<!--<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Trenogheno</title>
    <meta name="description" content="Home di trenogheno.it" />
    <meta name="keywords" content="trenogheno, trenini, modellismo" />
    <meta name="title" content="Home" />
    <meta name="author" content="Gruppo progetto TecWeb" />
    <meta name="language" content="italian it" />

    <link rel="stylesheet" type="text/css" href="styleGenerale.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="styleMobile.css" media="handheld, screen and (max-device-width:640px), only screen and (max-width:640px)" />
    <link rel="stylesheet" type="text/css" href="stylePrint.css" media="print" />
</head>-->

<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../includes/resources.php';
$pagetitle = "Trenogheno - Home";
$pagedescription = "Pagina Home di trenogheno.it";
$area_personale_link = "href=\"info.php\"";
$carrello_link = "class=\"header_current_link\"";
$login_link= "href=\"login.php\"";
$notizie_link = "href=\"notizie.php\"";
$home_link = "href=\"../index.php\"";
$servizi_link = "href=\"servizi.php\"";
$contatti_link = "href=\"contatti.php\"";
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
?>
