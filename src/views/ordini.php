<?php
require_once __DIR__ . DIRECOTRY_SEPARATOR . "../includes/resources.php";
use function ACCOUNT\getOrdersFromAccount;
use function ORDINE\getProdottiFromOrder;
use function ORDINE\getTotalFromOrder;
use function ORDINE\getDateFromOrder;

function printOrder($orderID) {
    $prodotti = getProdottiFromOrder($orderID);
    $data = getTotalFromOrder($orderID);
    $totale = getDateFromOrder($orderID);
    echo '<li class="order_date">'. ($data ? $data : "Errore: impossibile ricavare la data dell'ordine") . PHP_EOL;
    echo '<li class="order_total">'. ($totale ? $totale : "Errore: impossibile ricavare il totale dell'ordine") . PHP_EOL;
    echo "<li class=\"prodotti_container\">" . PHP_EOL;
    foreach($prodotti as $prodotto) {
        echo '<ul class="prodotto_item">' . PHP_EOL;
        echo '<li class="image"><img href="imgs/' . $prodotto["productID"]. '"/></li>'. PHP_EOL;
        echo '<li class="productID">'. $prodotto["productID"] ."</li>". PHP_EOL;
        echo '<li class="shippingID">'. $prodotto["shippingID"] ."</li>". PHP_EOL;
        echo '<li class="quantita">'. $prodotto["quantita"] ."</li>". PHP_EOL;
        echo '<li class="stato">'. $prodotto["stato"] ."</li>". PHP_EOL;
        echo '<li class="prezzo">'. $prodotto["prezzo"] ."</li>". PHP_EOL;
        echo "</ul>" . PHP_EOL;
    }
    echo "</li>" . PHP_EOL;

}

session_start();
if(isset($_SESSION["username"])) {
    /* Se l'utente è autenticato mostrerà la pagina giusta, farà
     * invece un redirect alla home se non lo è (caso in cui l'utente
     * richiede la pagina direttamente da url, invece che dalla home
     * dopo il login) */

    $tag_info = "<span class=\"current_link\">";
    include "template/header.php";

    $tag_ordini = "<span class=\"current_link\">";
    include "template/ap_navbar.php";

    echo '<main name="content">' . PHP_EOL;
    $orders = getOrdersFromAccount($_SESSION["username"]);
    echo '<ul id="ordini">' . PHP_EOL;
    foreach($orders as $order) {
        printOrder($order);
    }
    echo '</ul>' . PHP_EOL;
    echo '</main>' . PHP_EOL;
    
    include "template/footer.php";
}
else {
    /* Se l'utente non è impostato -> l'utente deve loggarsi ->
     * redirect alla pagina di login */
    $host  = $_SERVER['HTTP_HOST'];
    $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $extra = 'login.php';
    header("Location: http://$host$uri/$extra");
    exit();
}
?>
