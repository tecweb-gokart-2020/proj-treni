<?php
// Configurazione php e variabili globali
require_once("config.php");
require_once("variables.php");

// File `a oggetti'
require_once("class/db.class.php");

// File `procedurali'
require_once("utilities.php");
require_once("functions/account.php");
require_once("functions/carrello.php");
require_once("functions/indirizzo.php");
require_once("functions/spedizione.php");
require_once("functions/ordine.php");
require_once("functions/prodotto.php");

// File di vista
require_once(__DIR__ . DIRECTORY_SEPARATOR . "../views/functions/ap_navbar.php");
require_once("../views/functions/cartButton.php");
require_once("../views/functions/profileButton.php");
?>
