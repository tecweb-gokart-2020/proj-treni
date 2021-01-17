<?php
namespace VIEW;
require_once __DIR__ . DIRECTORY_SEPARATOR . "../../includes/resources.php";

function cartButton() {
    if(isset($_SESSION["cartID"])) {
        // mostra icona cart con count degli item dentro
    }
    else {
        // Mostra nulla...
    }
}
?>
