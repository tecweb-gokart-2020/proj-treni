<?php
namespace SPEDIZIONE;
require_once __DIR__ . DIRECTORY_SEPARATOR . '../resources.php';
use DB\DbAccess;
use function UTILITIES\isValidID;

// Ritorna lo stato di una spedizione, null se non esiste
function getStato($shipping_id){
    if(isValidID($shipping_id)){
        $dbAccess = new DBAccess();
        $connection = $dbAccess->openDbConnection();
        $query = "SELECT stato FROM spedizione WHERE shippingID = \"$shipping_id\"";
        $queryResult = mysqli_query($connection, $query);
        $dbAccess->closeDbConnection();
        $stato = mysqli_fetch_row($queryResult);
        return $stato;
    }else{
        return false;
    }
}

// Ritorna l'ordine associato ad una spedizione, null se non esiste
function getOrderFromShipping($shipping_id){
    if(isValidID($shipping_id)){
        $dbAccess = new DBAccess();
        $connection = $dbAccess->openDbConnection();
        $query = "SELECT orderID FROM spedizione WHERE shippingID = \"$shipping_id\"";
        $queryResult = mysqli_query($connection, $query);
        $dbAccess->closeDbConnection();
        $order_id = mysqli_fetch_row($queryResult);
        return $order_id;
    }else{
        return false;
    }
}

// Ritorna l'indirizzo associato ad una spedizione, null se non esiste
function getAddressFromShipping($shipping_id){
    if(isValidID($shipping_id)){
        $dbAccess = new DBAccess();
        $connection = $dbAccess->openDbConnection();
        $query = "SELECT addressID FROM spedizione WHERE shippingID = \"$shipping_id\"";
        $queryResult = mysqli_query($connection, $query);
        $address_id = mysqli_fetch_row($queryResult);
        $dbAccess->closeDbConnection();
        return $address_id[0];
    }else{
        return false;
    }
}

/* Crea una spedizione relativa all'ordine $orderID all'indirizzo
 * $addressID */
function makeNewSpedizione($orderID, $addressID, $status = null, $date = null) {
    if(isValidID($orderID) and isValidID($addressID)) {
        $db = new DBAccess();
        $connection = $db->openDbConnection();
        /* Era meglio usare valori di default? probabilmente si */
        $query = 'INSERT INTO spedizione(orderID, addressID, stato, data_prevista) VALUES ("' .
               $orderID . '", "' .
               $addressID . '", "' .
               $status . '", "' .
               $date . '")';
        $res = mysqli_query($connection, $query);
        $n = mysqli_affected_rows($res);
        return $n>=0;
        $dbAccess->closeDbConnection();
    }
}
?>
