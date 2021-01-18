<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../../includes/resources.php";
use function CARRELLO\getProdottiFromCarrello;

if(isset($_SESSION["cartID"])) {
    // mostra icona cart con count degli item dentro
    tag_init($tag_cart, '<a href="carrello.php" id="shopping-cart">', $tag_cart_close);
    $carrello = getProdottiFromCarrello($_SESSION["cartID"]);
    $count = $carrello ? count($carrello) : 0;
    echo $tag_cart . "\uf07a ". $count . $tag_cart_close;
}
else {
    /* Non si dovrebbe mai arrivare qui, vorrebbe dire che si può
     * accedere ad un punto senza cart inizializzato */
    error_log("Qualcosa è andato storto.... debuggare forte");
    die();
}
?>
