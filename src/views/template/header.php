<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../includes/resources.php';
use function PRODOTTO\searchProdotti;
use function CARRELLO\getProdottiFromCarrello;
use function UTILITIES\init_tag;

init_tag($tag_home, '<a href="home.php">', $tag_home_close);
init_tag($tag_novita, '<a href="prodotti.php?novita">', $tag_novita_close);
init_tag($tag_prodotti, '<a href="prodotti.php">', $tag_prodotti_close);
init_tag($tag_contatti, '<a href="contatti.php">', $tag_contatti_close);

session_start();

echo '<!DOCTYPE html>
<html lang="it">
    <head>
	<title>'. $pagetitle . '</title>
	<meta name="description" content="'.$pagedescription.'"/>
  <link rel="stylesheet" type="text/css" href="css/general.css"/>
    </head>
    <body>
        <nav class="aiuti">
            <ul>
                <li><a href="#content">Vai al contenuto della pagina</a>
            </ul>
        </nav>
	<header>
	    <!-- Logo -->
	    <h1>'. $tag_home .'TrenoGheno'. $tag_home_close .'</h1>
	    <!-- Ricerca -->
	    <form id="ricercaHeader" action="prodotti.php" method="get">
		<input type="search" id="searchQuery" name="searchQuery" placeholder="Cosa cerchi?" maxlength="40"/>
		<input type="submit" name="search" value="Cerca"/>';
		if(isset($_GET['search'])){
			$searchString = $_GET['searchQuery'];
			$listaProdotti = searchProdotti($searchString);
		}		
echo '</form>';	    
echo '<nav>
		<ul id="pagine">
		    <li>
			' . $tag_prodotti . 'Prodotti'. $tag_prodotti_close .'
		    </li>				
		    <li>
			' . $tag_contatti . 'Contatti'. $tag_contatti_close .'
			</li>
		</ul>
		<ul id="icons">
			<li>' . PHP_EOL;
if(isset($_SESSION["username"])) {
    // mostra icona utente
    init_tag($tag_info, '<a href="info.php" id="user-icon">', $tag_info_close);
    echo $tag_info . '<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="user" class="svg-inline--fa fa-user fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-74.2-60.2-134.4-134.4-134.4z"></path></svg>' . $tag_info_close;
    echo '<li id="logout"><a href="logout.php">Logout</a></li>';
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
    echo $tag_cart . '<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="shopping-cart" class="svg-inline--fa fa-shopping-cart fa-w-18" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path fill="currentColor" d="M528.12 301.319l47.273-208C578.806 78.301 567.391 64 551.99 64H159.208l-9.166-44.81C147.758 8.021 137.93 0 126.529 0H24C10.745 0 0 10.745 0 24v16c0 13.255 10.745 24 24 24h69.883l70.248 343.435C147.325 417.1 136 435.222 136 456c0 30.928 25.072 56 56 56s56-25.072 56-56c0-15.674-6.447-29.835-16.824-40h209.647C430.447 426.165 424 440.326 424 456c0 30.928 25.072 56 56 56s56-25.072 56-56c0-22.172-12.888-41.332-31.579-50.405l5.517-24.276c3.413-15.018-8.002-29.319-23.403-29.319H218.117l-6.545-32h293.145c11.206 0 20.92-7.754 23.403-18.681z"></path></svg><span id="counter">'. $count . '</span>' . $tag_cart_close;
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
unset($tag_cart);

unset($tag_home_close);
unset($tag_info_close);
unset($tag_novita_close);
unset($tag_prodotti_close);
unset($tag_contatti_close);
unset($tag_cart_close);
?>
