<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../../includes/resources.php";
namespace VIEW;

function cartButton() {
    if(isset($_SESSION["cartID"])) {
        // mostra icona cart con count degli item dentro
    }
    else {
        // Mostra nulla...
    }
}
?>
