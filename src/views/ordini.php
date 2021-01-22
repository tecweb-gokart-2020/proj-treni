<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../includes/resources.php";
use function ACCOUNT\getOrdersFromAccount;
use function ORDINE\getProdottiFromOrder;
use function ORDINE\getTotalFromOrder;
use function ORDINE\getDateFromOrder;
use function INDIRIZZO\getInfoFromAddress;
use function SPEDIZIONE\getAddressFromShipping;

function printAddress($addressID) {
    $addr = getInfoFromAddress($addressID);
    if($addr){
        echo '<ul class="display-address">' . PHP_EOL;
        echo '<li class="nome">' . $addr["nome"] . "</li>" . PHP_EOL;
        echo '<li class="via">' . $addr["via"] . "</li>" . PHP_EOL;
        echo '<li class="numero">' . $addr["numero"] . "</li>" . PHP_EOL;
        echo '<li class="citta">' . $addr["citta"] . "</li>" . PHP_EOL;
        echo '<li class="stato">' . $addr["stato"] . "</li>" . PHP_EOL;
        echo '<li class="telefono">' . $addr["telefono"] . "</li>" . PHP_EOL;
        echo '<li class="cap">' . $addr["cap"] . "</li>" . PHP_EOL;
        echo '</ul>' . PHP_EOL;
    }
    else {
	var_dump($addressID);
        echo "Indirizzo non valido, qualcosa è andato storto...";
    }
}

function printOrder($orderID) {
    $prodotti = getProdottiFromOrder($orderID);
    $g_prod = array();
    /* Raggruppa i prodotti secondo il loro shipping id*/
    foreach($prodotti as $prodotto) {
        if(!isset($g_prod[$prodotto["shippingID"]])){
            $g_prod[$prodotto["shippingID"]] = array();
        }
        array_push($g_prod[$prodotto["shippingID"]], $prodotto);
    }
    $data = getTotalFromOrder($orderID);
    $totale = getDateFromOrder($orderID);
    echo '<li class="order_date">'. ($data ? $data : "Errore: impossibile ricavare la data dell'ordine") . PHP_EOL;
    echo '<li class="order_total">'. ($totale ? $totale : "Errore: impossibile ricavare il totale dell'ordine") . PHP_EOL;
    echo '<li class="prodotti_container">' . PHP_EOL;
    foreach ($g_prod as $ship) {
        // Stampa indirizzo
        /* ogni elemento di g_prod è una mappa, che contiene i dati
         * del prodotto con quell'id. di fatto infati il passaggio
         * prima li raggruppava per shippingID. a questo punto deve
         * esistere almeno un elemento dentro $ship, dato che
         * altrimenti non sarebbe stato inizializzato al
         * raggruppamento. [0]["shippingID"] è equivalente alla chiave
         * di ship, che è proprio lo shippingID dell'indirizzo */
        printAddress(getAddressFromShipping($ship[0]["shippingID"]));
        //stampa prodotti spediti a quell'indirizzo
        foreach($ship as $prodotto) {
            echo '<ul class="prodotto_item">' . PHP_EOL;
            echo '<li class="image"><img src="img/' . $prodotto["productID"]. '"/></li>'. PHP_EOL;
            echo '<li class="productID">'. $prodotto["productID"] ."</li>". PHP_EOL;
            //if($prodotto["shippingID"]){
            //echo '<li class="shippingID">'. $prodotto["shippingID"] ."</li>". PHP_EOL;
            //}
            echo '<li class="quantita">'. $prodotto["quantita"] ."</li>". PHP_EOL;
            echo '<li class="stato">'. $prodotto["stato"] ."</li>". PHP_EOL;
            echo '<li class="prezzo">'. $prodotto["prezzo"] ."</li>". PHP_EOL;
            echo "</ul>" . PHP_EOL;
        }
    }
    echo "</li>" . PHP_EOL;
}

session_start();
$_SESSION["username"] = "user";
$_SESSION["cartID"] = 2;
if(isset($_SESSION["username"])) {
    /* Se l'utente è autenticato mostrerà la pagina giusta, farà
     * invece un redirect alla home se non lo è (caso in cui l'utente
     * richiede la pagina direttamente da url, invece che dalla home
     * dopo il login) */

    $tag_info = "<span class=\"current_link\">";
    include "template/header.php";

    $current_page = "area personale >> i miei ordini";
    include "template/breadcrumb.php";
    
    $tag_ordini = "<span class=\"current_link\">";
    include "template/ap_navbar.php";

    echo '<main id="content">' . PHP_EOL;
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
