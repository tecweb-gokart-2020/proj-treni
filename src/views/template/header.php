<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../includes/resources.php';
use function PRODOTTO\searchProdotti;
use function VIEW\profileButton;
use function VIEW\cartButton;
use function UTILITIES\init_tag;

init_tag($tag_home, '<a href="home.php">', $tag_home_close);
init_tag($tag_info, '<a href="info.php">', $tag_info_close);
init_tag($tag_novita, '<a href="prodotti.php?novita">', $tag_novita_close);
init_tag($tag_prodotti, '<a href="prodotti.php">', $tag_prodotti_close);
init_tag($tag_contatti, '<a href="contatti.php">', $tag_contatti_close);

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
	    '. $tag_home .'<h1>TrenoGheno</h1>'. $tag_home_close .'
	    <!-- Ricerca -->
	    <form id="ricercaHeader" action="" method="get">
		<input type="search" id="searchQuery" name="searchQuery" placeholder="Cosa cerchi?" maxlength="40"/>
		<input type="submit" name="search" value="Cerca"/>';
		if(isset($_GET['search'])){
			$searchString = $_GET['searchQuery'];
			$listaProdotti = searchProdotti($searchString);
		}		
	    echo '</form>';	    
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

unset($tag_home);
unset($tag_info);
unset($tag_novita);
unset($tag_prodotti);
unset($tag_contatti);

unset($tag_home_close);
unset($tag_info_close);
unset($tag_novita_close);
unset($tag_prodotti_close);
unset($tag_contatti_close);
?>
