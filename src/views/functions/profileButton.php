<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../../includes/resources.php";
namespace VIEW;

function profileButton() {
    if(isset($_SESSION["username"])) {
        // mostra icona utente, cliccandoci sopra si va ad info.php
    }
    else {
        // mostra pulsante login/register
    }
}
?>
