<?php
// unico file da includere con tutto il backend
require_once __DIR__ . DIRECTORY_SEPARATOR . "includes/resources.php";

// variabili riferite alla singola pagina
$pagetitle = "Homepage";
$pagedescription = "Descrizione della homepage";

// Esempio di inclusione delle viste header, corpo di index e footer
include __DIR__ . DIRECTORY_SEPARATOR . "views/template/header.php";
include __DIR__ . DIRECTORY_SEPARATOR . "views/template/footer.php";
?>
