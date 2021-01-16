<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../includes/resources.php';
use function PRODOTTO\searchProdotti;
use function VIEW\productButton;
use function VIEW\cartButton;

if(!isset($tag_info)) {
    $tag_info = '<a href="info.php">';
}
if(!isset($tag_novita)) {
    $tag_novita = '<a href="prodotti.php?novita">';
}
if(!isset($tag_prodotti)) {
    $tag_prodotti = '<a href="prodotti.php">';
}
if(!isset($tag_contatti)) {
    $tag_contatti = '<a href="contatti.php">';
}
/* Sta roba prende il tag definito da quello sopra e imposta quello di
chiusura */
preg_match('/^<\w{1,}/', $tag_info, $tmp);
preg_match('/\w{1,}/', $tmp[0], $tmp);
$tag_info_close = "</" . $tmp[0] . ">";

preg_match('/^<\w{1,}/', $tag_prodotti, $tmp);
preg_match('/\w{1,}/', $tmp[0], $tmp);
$tag_prodotti_close = "</" . $tmp[0] . ">";

preg_match('/^<\w{1,}/', $tag_contatti, $tmp);
preg_match('/\w{1,}/', $tmp[0], $tmp);
$tag_contatti_close = "</" . $tmp[0] . ">";

preg_match('/^<\w{1,}/', $tag_novita, $tmp);
preg_match('/\w{1,}/', $tmp[0], $tmp);
$tag_novita_close = "</" . $tmp[0] . ">";

echo '<!DOCTYPE html>
<html>
    <head>
	<title>'. $pagetitle . '</title>
	<metaname="description" content="'.$pagedescription.'"/>
            <linkrel="stylesheet" type="text/css" href="styles/resource.css"/>
    </head>
    <body>
	<header>
	    <!-- Logo -->
	    <a href="/" id="banner"><h1>TrenoGheno</h1></a>
	    <!-- Ricerca -->
	    <form id="ricercaHeader" action="" method="get">
		<input type="search" id="searchQuery" name="searchQuery" placeholder="Cosa cerchi?" maxlength="40"/>
		<input type="submit" name="search" value="Cerca"/>';
		if(isset($_GET['search'])){
			$searchString = $_GET['searchQuery'];
			$listaProdotti = searchProdotti($searchString);
		}
echo '</form> 
	    <nav>
		<ul>
		    <li>
			<!-- Test -->
			' . $tag_info . 'Area personale'. $tag_info_close .'
		    </li>
		    <li>
			' . $tag_novita . 'Novità'. $tag_novita_close .'
		    </li>
		    <li>
			' . $tag_prodotti . 'Prodotti'. $tag_prodotti_close .'
		    </li>				
		    <li>
			' . $tag_contatti . 'Contatti'. $tag_contatti_close .'
		    </li>
		    <li>
			<!-- Test -->
			' . ""/*profileButton()*/ .'
		    </li>
		    <li>
			<!-- Test -->
			' . ""/*cartButton()*/ .'
		    </li>
		</ul>
	    </nav>
	</header>';

unset($tag_info);
unset($tag_novita);
unset($tag_prodotti);
unset($tag_contatti);

unset($tag_info_close);
unset($tag_novita_close);
unset($tag_prodotti_close);
unset($tag_contatti_close);
?>
