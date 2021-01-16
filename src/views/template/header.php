<?php			
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../includes/resources.php';
use function PRODOTTO\searchProdotti;

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
	    echo '</form>';	    
	    //icona login o loggato
	    if(isset($_SESSION["username"])){
			echo '<a id="linkAreaPersonale" ' . $area_personale_link . '><span class="icona" id="iconaUtente"></span>Area Personale</a>';
		} else {	
		    echo '<a id="linkLogin" ' . $login_link . '><span class="icona" id="iconaLogin"></span>Accedi</a>';
		}
	    echo ';<!-- Carrello -->
	    <a ' . $carrello_link . '><span class="icona" id="iconaCarrello"></span>Carrello</a>
	    <!-- Menù -->
	    <nav>
			<ul>
			    <li>
				<a ' . $prodotti_link . '>Prodotti</a>
			    </li>
			    <li>
				<a ' . $contatti_link . '>Contatti</a>
			    </li>
			</ul>
	    </nav>		
	</header>';
?>
