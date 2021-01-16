<?php
// Configurazione php e variabili globali
require_once __DIR__ . DIRECTORY_SEPARATOR . "config.php";
require_once __DIR__ . DIRECTORY_SEPARATOR . "variables.php";

// File `a oggetti'
require_once __DIR__ . DIRECTORY_SEPARATOR . "class/db.class.php";

// File `procedurali'
require_once __DIR__ . DIRECTORY_SEPARATOR . "utilities.php";
require_once __DIR__ . DIRECTORY_SEPARATOR . "functions/account.php";
require_once __DIR__ . DIRECTORY_SEPARATOR . "functions/carrello.php";
require_once __DIR__ . DIRECTORY_SEPARATOR . "functions/indirizzo.php";
require_once __DIR__ . DIRECTORY_SEPARATOR . "functions/spedizione.php";
require_once __DIR__ . DIRECTORY_SEPARATOR . "functions/ordine.php";
require_once __DIR__ . DIRECTORY_SEPARATOR . "functions/prodotto.php";

// File di vista
require_once __DIR__ . DIRECTORY_SEPARATOR . "../views/functions/ap_navbar.php";
require_once __DIR__ . DIRECTORY_SEPARATOR . "../views/functions/cartButton.php";
require_once __DIR__ . DIRECTORY_SEPARATOR . "../views/functions/profileButton.php";
?>
