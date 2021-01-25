<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../includes/resources.php";
use function ACCOUNT\getOrdersFromAccount;
use function ORDINE\getProdottiFromOrder;
use function ORDINE\getTotalFromOrder;
use function ORDINE\getDateFromOrder;
use function INDIRIZZO\getInfoFromAddress;
use function SPEDIZIONE\getAddressFromShipping;
use function PRODOTTO\getInfoFromProdotto;

function printAddress($addressID) {
    $addr = getInfoFromAddress($addressID);
    if($addr){
        echo '<ul class="display-address">' . PHP_EOL;
        echo '<li class="nome">Nome: ' . $addr["nome"] . "</li>" . PHP_EOL;
        echo '<li class="via">Via: ' . $addr["via"] . "</li>" . PHP_EOL;
        echo '<li class="numero">Civico: ' . $addr["numero"] . "</li>" . PHP_EOL;
        echo '<li class="citta">Città: ' . $addr["citta"] . "</li>" . PHP_EOL;
        echo '<li class="stato">Stato: ' . $addr["stato"] . "</li>" . PHP_EOL;
        echo '<li class="telefono">Telefono: ' . $addr["telefono"] . "</li>" . PHP_EOL;
        echo '<li class="cap"><abbr title="Codice Avviamento Postale">CAP</abbr>: ' . $addr["cap"] . "</li>" . PHP_EOL;
        echo '</ul>' . PHP_EOL;
    }
    else {
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
    $totale = getTotalFromOrder($orderID);
    $data = getDateFromOrder($orderID);
    echo '<li class="ordine"><ul>';
    echo '<li class="order_date"> Data ordine: '. ($data ? $data : "Errore: impossibile ricavare la data dell'ordine") . PHP_EOL;
    echo '<li class="order_total"> Totale: '. ($totale ? $totale : "Errore: impossibile ricavare il totale dell'ordine") . PHP_EOL;
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
            $info = getInfoFromProdotto($prodotto["productID"]);
            echo '<a href="paginaSingoloProdotto.php?codArticolo='.$prodotto["productID"].'"><ul class="prodotto_item">' . PHP_EOL;
            echo '<li class="image"><img src="imgs/' . $prodotto["productID"]. '" alt="'.$info["marca"].' '.$prodotto["productID"].'"/></li>'. PHP_EOL;
            echo '<li class="productID"> ID: '. $prodotto["productID"] ."</li>". PHP_EOL;
            echo '<li class="quantita">Quantità: '. $prodotto["quantita"] ."</li>". PHP_EOL;
            echo '<li class="stato">Stato: '. $prodotto["stato"] ."</li>". PHP_EOL;
            echo '<li class="prezzo">Prezzo: '. $prodotto["prezzo"] ." €</li>". PHP_EOL;
            echo "</ul></a>" . PHP_EOL;
        }
    }
    echo "</li></ul>" . PHP_EOL;
}

session_start();

if(isset($_SESSION["username"])) {
    /* Se l'utente è autenticato mostrerà la pagina giusta, farà
     * invece un redirect alla home se non lo è (caso in cui l'utente
     * richiede la pagina direttamente da url, invece che dalla home
     * dopo il login) */

    $tag_info = "";
    $pagetitle="Ordini - Trenene";
    $pagedescription = "Pagina area personale contenente gli ordini effettuati, gli articoli sono divisi per ordine e indirizzo di spedizione";
    include "template/header.php";

    $current_page = "area personale >> i miei ordini";
    include "template/breadcrumb.php";
    
    $tag_ordini = "<span class=\"current_link\">";
    include "template/ap_navbar.php";

    echo '<main id="content"><div id="areaPersonale">' . PHP_EOL;
    $orders = getOrdersFromAccount($_SESSION["username"]);
    echo '<ul id="ordini">' . PHP_EOL;
    foreach($orders as $order) {
        printOrder($order);
    }
    echo '</ul>' . PHP_EOL;
    echo '</div></main>' . PHP_EOL;
    
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
