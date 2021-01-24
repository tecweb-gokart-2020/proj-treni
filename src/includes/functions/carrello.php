<?php
namespace CARRELLO;
require_once __DIR__ . DIRECTORY_SEPARATOR . '../resources.php';
use mysqli;
use Exception;
use DB\DBAccess;
use function UTILITIES\isValidID;
use function ORDINE\makeNewOrdine;
use function PRODOTTO\ordina;
use function SPEDIZIONE\makeNewSpedizione;
use function PRODOTTO\getInfoFromProdotto;
use function UTILITIES\cleanUp;

// Ritorna un array associativo di prodotti presenti in un carrello, null se non c'è alcun prodotto
function getProdottiFromCarrello($cart_id){
    if(isValidID($cart_id)){
        $dbAccess = new DBAccess();
        $connection = $dbAccess->openDbConnection();
        $query = "SELECT codArticolo, quantita FROM contenuto_carrello WHERE cartID = \"$cart_id\"";
        $queryResult = mysqli_query($connection, $query);
        $listaProdotti = array();
        if(mysqli_num_rows($queryResult)!=0){
            while($riga = mysqli_fetch_assoc($queryResult)){
                array_push($listaProdotti,$riga);
            }
        }
        $dbAccess->closeDbConnection();
        return $listaProdotti;
    }else{
        return false;
    }
}

/* Fatta al volo, peer review ben accetta */
function getAccountFromCarrello($cart_id){
    if(isValidID($cart_id)){
        $dbAccess = new DBAccess();
        $connection = $dbAccess->openDbConnection();
        $query = "SELECT username FROM utente WHERE cartID = \"$cart_id\"";
        $queryResult = mysqli_query($connection, $query);
        $account = mysqli_fetch_row($queryResult)[0];
        $dbAccess->closeDbConnection();
        return $account;
    }else{
        return false;
    }
}

// Inserisce un nuovo carrello e ritorna il suo ID, false in caso di fallimento
function getNewCarrello(){
    $dbAccess = new DBAccess();
    $connection = $dbAccess->openDbConnection();
    $query = "SELECT cartID FROM carrello ORDER BY cartID DESC LIMIT 1";
    $queryResult = mysqli_query($connection, $query);
    $cart_id = mysqli_fetch_row($queryResult)[0] + 1;
    $queryInsert = "INSERT INTO carrello(cartID) VALUES (\"$cart_id\")";
    if(mysqli_query($connection, $queryInsert)){
        $dbAccess->closeDbConnection();
        return $cart_id;
    }else{
        $dbAccess->closeDbConnection();
        return false;
    }
}

function removeFromCart($cartID, $prodotto) {
	$db = new DBAccess();
	$connection = $db->openDbConnection();
	$query = "DELETE FROM contenuto_carrello WHERE cartID=$cartID AND codArticolo=" . $prodotto;
	$response = mysqli_query($connection, $query);
	return $response;
}

/* cartID è l'id ben formato di un carrello, $address è una mappa che
 * contiene tutti i campi necessari per la definizione di un indirizzo
 * (come esempio vedere views/checkout.php linea 26). Ritorna true se
 * l'acquisto va a buon fine, -1 se l'id del carrello è invalido, 0 se
 * l'indirizzo ha qualche campo errato */
function checkout($cartID, $addressID) {
    $prodotti = getProdottiFromCarrello($cartID);
    $account = getAccountFromCarrello($cartID);
    $totale = 0;
    foreach($prodotti as $prodotto) {
        $prezzo = getInfoFromProdotto($prodotto["codArticolo"])["prezzo"];
        $qta = getInfoFromProdotto($prodotto["codArticolo"])["quantita"];
        $totale+=($prezzo*$qta);
    }
    $orderID = makeNewOrdine($account, $totale);
    $ship = makeNewSpedizione($orderID, $addressID, 'Processing');
    // var_dump($prodotti);
    // var_dump($account);
    // var_dump($totale);
    // var_dump($orderID);
    var_dump($ship);
    $response = true;
    foreach($prodotti as $prodotto){
	    if($response){
        	$response = ordina($prodotto["codArticolo"],
               				$prodotto["quantita"],
                			getInfoFromProdotto($prodotto["codArticolo"])["prezzo"],
                			$orderID,
                			$ship);
		if($response) {
			removeFromCart($cartID, $prodotto["codArticolo"]);
		}
	    }
    }
    return true;
}

/* cartID e codice articolo ben formati, controlla che siano id validi
 * e poi aggiunge al carrello cartID l'articolo $articolo */
function addToCart($cartID, $articolo, $qty) {
    if(isValidID($cartID) and isValidID($articolo)) {
	$db = new DBAccess();
	$connection = $db->openDbConnection();
	$query = 'SELECT quantita FROM contenuto_carrello WHERE cartID='. $cartID.
	       ' AND codArticolo=' . $articolo;
	$quantita = mysqli_query($connection, $query);
	$quantita = mysqli_fetch_row($quantita)[0];
	if($quantita > 0){
		$query = "UPDATE contenuto_carrello SET quantita = quantita + $qty WHERE cartID = $cartID AND codArticolo = $articolo";
	} else {
		$query = "INSERT INTO contenuto_carrello(cartID, codArticolo, quantita) VALUES ($cartID, $articolo, $qty)";
	}
	// var_dump($query);
	$res = mysqli_query($connection, $query);
        return mysqli_affected_rows($connection);
    } else {
    	throw new Exception("Oh oh...");
    }
}

function setQuantityInCart($cart, $product, $quantity){
	if(isValidID($cart)){
		if(isValidID($product)){
			$db = new DBAccess();
			$connection = $db->openDbConnection();
			$cart = cleanUp($cart);
			$product = cleanUp($product);
			$quantity = cleanUp($quantity);
			var_dump($quantity);
			var_dump($cart);
			var_dump($product);
			$query = "UPDATE contenuto_carrello SET quantita=$quantity WHERE cartID=$cart AND codArticolo=$product";
			$res = mysqli_query($connection, $query);
			return mysqli_affected_rows($connection);
		}
		else throw new Exception("Prodotto non passa il check");
	}
	else throw new Exception("carrello non passa il check");
}
?>
