<?php
namespace SPEDIZIONE;
//require_once "../resources.php";
use DB\DbAccess;
use function UTILITIES\isValidShipping;

// Ritorna lo stato di una spedizione, null se non esiste
function getStato($shipping_id){
    if(isValidShipping($shipping_id)){
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
    if(isValidShipping($shipping_id)){
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
    if(isValidShipping($shipping_id)){
        $dbAccess = new DBAccess();
        $connection = $dbAccess->openDbConnection();
        $query = "SELECT addressID FROM spedizione WHERE shippingID = \"$shipping_id\"";
        $queryResult = mysqli_query($connection, $query);
        $dbAccess->closeDbConnection();
        $address_id = mysqli_fetch_row($queryResult);
        return $address_id;
    }else{
        return false;
    }
}