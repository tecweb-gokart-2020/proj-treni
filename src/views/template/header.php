<?php
 require_once __DIR__ . DIRECTORY_SEPARATOR . '../../includes/resources.php';
use function PRODOTTO\searchProdotti;
if(!isset($tag_info)) {
    $tag_info = '<a href="info.php">'
}
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
			' . profileButton() .'
		    </li>
		    <li>
			<!-- Test -->
			' . cartButton() .'
		    </li>
		</ul>
	    </nav>
	</header>';
?>
