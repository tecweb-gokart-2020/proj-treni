<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../includes/resources.php';
use function PRODOTTO\searchProdotti;
use function CARRELLO\getProdottiFromCarrello;
use function UTILITIES\init_tag;

init_tag($tag_home, '<a id="tag-home-header" href="home.php">', $tag_home_close);
init_tag($tag_novita, '<a href="prodotti.php?novita">', $tag_novita_close);
init_tag($tag_prodotti, '<a href="prodotti.php">', $tag_prodotti_close);
init_tag($tag_contatti, '<a href="contatti.php">', $tag_contatti_close);

session_start();

echo '<!DOCTYPE html>
<html lang="it">
    <head>
	<title>'. $pagetitle . '</title>
	<meta name="description" content="'.$pagedescription.'"/>
	<meta name="viewport" content="width=device-width">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  	<link rel="stylesheet" type="text/css" href="css/general.css" media="screen"/>
  	<link rel="stylesheet" type="text/css" href="css/mobile.css" media="handheld, screen and (max-device-width:640px), only screen and (max-width:640px)" />
	'. $js .'
	<link rel="stylesheet" type="text/css" href="css/print.css" media="print"/>
    </head>
    <body>
        <nav id="aiuti" aria-label="aiuti alla navigazione">
            <ul>
                <li><a href="#content">Vai al contenuto della pagina</a>
            </ul>
        </nav>
	<header>
	    <!-- Logo -->
	    <h1 id="h1header">'. $tag_home .'TRENENE'. $tag_home_close .'</h1>
	    <!-- Ricerca -->
	    <form id="ricercaHeader" action="prodotti.php" method="get">
		<label id="labelRicercaHeader" for="searchQuery">Ricerca prodotti</label>
		<input class="headerInputForm" type="search" id="searchQuery" name="searchQuery" placeholder="Cerca nei prodotti" maxlength="40"/>
		<input class="headerInputForm" type="submit" name="search" value="Cerca"/>';
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
    // mostra icona di aggiunta di un prodotto se l'utente è admin
    if($_SESSION["username"] == "admin"){
        init_tag($tag_add, '<a href="adminAdd.php" id="admin-add-icon">', $tag_add_close);
        echo $tag_add . '<i class="fa fa-plus"></i>' .$tag_add_close;
        echo '</li><li>';
    }
    // mostra l'icona utente
    $personal_page = '<a href="info.php" id="user-icon">';
    init_tag($tag_info, $personal_page, $tag_info_close);
    echo $tag_info . '<i class="fa fa-user"></i>' . $tag_info_close;
}
else {
    echo '<a id="login" href="login.php">Entra</a>' . PHP_EOL;
    echo '</li>' . PHP_EOL;
    echo '<li>' . PHP_EOL;
    echo '<a id="register" href="register.php">Registrati</a>' . PHP_EOL;
}

echo '</li>
	    <li>
		<!-- Test -->' . PHP_EOL;

if(isset($_SESSION["cartID"])) {
    // mostra icona cart con count degli item dentro
    init_tag($tag_cart, '<a href="carrello.php" id="cart-icon">', $tag_cart_close);
    $carrello = getProdottiFromCarrello($_SESSION["cartID"]);
    $count = $carrello ? count($carrello) : 0;
    echo $tag_cart . '<i class="fa fa-shopping-cart"></i>'. $count . '</span>' . $tag_cart_close;
}
else {
    /* Non si dovrebbe mai arrivare qui, vorrebbe dire che si può
     * accedere ad un punto senza cart inizializzato */
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
unset($js);

unset($tag_home_close);
unset($tag_info_close);
unset($tag_novita_close);
unset($tag_prodotti_close);
unset($tag_contatti_close);
unset($tag_cart_close);
?>
