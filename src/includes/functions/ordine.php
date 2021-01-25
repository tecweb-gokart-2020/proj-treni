<?php
namespace ORDINE;
require_once __DIR__ . DIRECTORY_SEPARATOR . '../resources.php';
use DB\DbAccess;
use function UTILITIES\isValidID;
use function UTILITIES\username_exists;

// Ritorna la data in cui è stato fatto un ordine dato il suo ID, null se l'ordine non esiste
function getDateFromOrder($order_id){
    if(isValidID($order_id)){
        $dbAccess = new DBAccess();
        $connection = $dbAccess->openDbConnection();
        $query = "SELECT data_ordine FROM ordine WHERE orderID = \"$order_id\"";
        $queryResult = mysqli_query($connection, $query);
        $data_ordine = mysqli_fetch_row($queryResult)[0];
        $dbAccess->closeDbConnection();
        return $data_ordine;
    }else{
        return false;
    }
}

// Ritorna il prezzo totale di un ordine dato il suo ID, null se l'ordine non esiste
function getTotalFromOrder($order_id){
    if(isValidID($order_id)){
        $dbAccess = new DBAccess();
        $connection = $dbAccess->openDbConnection();
        $query = "SELECT total FROM ordine WHERE orderID = \"$order_id\"";
        $queryResult = mysqli_query($connection, $query);
        $totale = mysqli_fetch_row($queryResult)[0];
        $dbAccess->closeDbConnection();
        return $totale;
    }else{
        return false;
    }
}

// Ritorna l'ID dell'account associato ad un ordine, null se l'ordine non esiste
function getAccountFromOrder($order_id){
    if(isValidID($order_id)){
        $dbAccess = new DBAccess();
        $connection = $dbAccess->openDbConnection();
        $query = "SELECT username FROM ordine WHERE orderID = \"$order_id\"";
        $queryResult = mysqli_query($connection, $query);
        $dbAccess->closeDbConnection();
        $account_id = mysqli_fetch_row($queryResult);
        return $account_id;
    }else{
        return false;
    }
}

// Ritorna un array associativo di prodotti ordinati, null se non c'è alcun prodotto o ordine
function getProdottiFromOrder($order_id){
    if(isValidID($order_id)){
        $dbAccess = new DBAccess();
        $connection = $dbAccess->openDbConnection();
        $query = 'SELECT codArticolo, shippingID, quantita, prezzo_netto FROM prodotto_ordinato WHERE orderID = "' . $order_id . '"';
        $queryResult = mysqli_query($connection, $query);
        $listaProdotti = array();
        if($queryResult){
            while($riga = mysqli_fetch_assoc($queryResult)){
                $singoloProdotto = array(
                    "productID" => $riga["codArticolo"],
                    "shippingID" => $riga["shippingID"],
                    "quantita" => $riga["quantita"],
                    "prezzo" => $riga["prezzo_netto"]
                );    
                array_push($listaProdotti,$singoloProdotto);
            }
        }
        $dbAccess->closeDbConnection();
        return $listaProdotti;
    }else{
        return false;
    }
}

/* Dato un carrello e un indirizzo inserice i prodotti del carrello in
 * prodotto_ordinato e crea una spedizione all'indirizzo addressID */
function makeNewOrdine($user, $total, $data = "NOW()") {
    if(username_exists($user)) {
        $db = new DBAccess();
        $connection = $db->openDbConnection();
        $query = "SELECT orderID FROM ordine ORDER BY orderID DESC LIMIT 1";
        $queryResult = mysqli_query($connection, $query);
        $orderID = mysqli_fetch_row($queryResult)[0] + 1;
        $query = 'INSERT INTO ordine(orderID, username, total, data_ordine) VALUES ('. $orderID .', "'. $user .'", '. $total.', '. $data .')';
        $queryResult = mysqli_query($connection, $query);
        $db->closeDbConnection();
        if($queryResult) {
            return $orderID;
        }
    } else {
        return false;
    }
}
?>
