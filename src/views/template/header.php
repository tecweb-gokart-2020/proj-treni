<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../includes/resources.php';
use function PRODOTTO\searchProdotti;
use function CARRELLO\getProdottiFromCarrello;
use function UTILITIES\init_tag;

init_tag($tag_home, '<a href="home.php">', $tag_home_close);
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
			' . PHP_EOL;
if(isset($_SESSION["username"])) {
    // mostra icona utente
    init_tag($tag_info, '<a href="info.php" id="user-icon">', $tag_cart_close);
    echo $tag_info . "&#xf007 " . $tag_info_close;
}
else {
    echo '<a href="login.html">Entra</a>' . PHP_EOL;
    echo '</li>' . PHP_EOL;
    echo '<li>' . PHP_EOL;
    echo '<a href="register.html">Registrati</a>' . PHP_EOL;
}

echo '</li>
		    <li>
			<!-- Test -->' . PHP_EOL;

if(isset($_SESSION["cartID"])) {
    // mostra icona cart con count degli item dentro
    init_tag($tag_cart, '<a href="carrello.php" id="cart-icon">', $tag_cart_close);
    $carrello = getProdottiFromCarrello($_SESSION["cartID"]);
    $count = $carrello ? count($carrello) : 0;
    echo $tag_cart . "&#xf07a ". $count . $tag_cart_close;
}
else {
    /* Non si dovrebbe mai arrivare qui, vorrebbe dire che si può
     * accedere ad un punto senza cart inizializzato */
    error_log("Qualcosa è andato storto.... debuggare forte");
    die();
}

echo '</li>
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
