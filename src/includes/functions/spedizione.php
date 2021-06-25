<?php

namespace SPEDIZIONE;

require_once __DIR__ . DIRECTORY_SEPARATOR . '../resources.php';
use DB\DbAccess;
use function UTILITIES\isValidID;

// Ritorna lo stato di una spedizione, null se non esiste
function getStato($shipping_id)
{
    if (isValidID($shipping_id)) {
        $dbAccess = new DBAccess();
        $connection = $dbAccess->openDbConnection();
        $query = "SELECT stato FROM spedizione WHERE shippingID = \"$shipping_id\"";
        $queryResult = mysqli_query($connection, $query);
        $dbAccess->closeDbConnection();
        $stato = mysqli_fetch_row($queryResult);
        return $stato;
    } else {
        return false;
    }
}

// Ritorna l'ordine associato ad una spedizione, null se non esiste
function getOrderFromShipping($shipping_id)
{
    if (isValidID($shipping_id)) {
        $dbAccess = new DBAccess();
        $connection = $dbAccess->openDbConnection();
        $query = "SELECT orderID FROM spedizione WHERE shippingID = \"$shipping_id\"";
        $queryResult = mysqli_query($connection, $query);
        $dbAccess->closeDbConnection();
        $order_id = mysqli_fetch_row($queryResult);
        return $order_id;
    } else {
        return false;
    }
}

// Ritorna l'indirizzo associato ad una spedizione, null se non esiste
function getAddressFromShipping($shipping_id)
{
    if (isValidID($shipping_id)) {
        $dbAccess = new DBAccess();
        $connection = $dbAccess->openDbConnection();
        $query = "SELECT addressID FROM spedizione WHERE shippingID = \"$shipping_id\"";
        $queryResult = mysqli_query($connection, $query);
        $address_id = mysqli_fetch_row($queryResult);
        $dbAccess->closeDbConnection();
        return $address_id[0];
    } else {
        return false;
    }
}

/* Crea una spedizione relativa all'ordine $orderID all'indirizzo
 * $addressID */
function makeNewSpedizione($orderID, $addressID, $status = null, $date = "NOW()")
{
    if (isValidID($orderID) and isValidID($addressID)) {
        $db = new DBAccess();
        $connection = $db->openDbConnection();
        $query = "SELECT shippingID FROM spedizione ORDER BY shippingID DESC LIMIT 1";
        $queryResult = mysqli_query($connection, $query);
        $shippingID = mysqli_fetch_row($queryResult)[0] + 1;
        $query = 'INSERT INTO spedizione(shippingID, orderID, addressID, stato, data_prevista) VALUES (' .
        $shippingID . ', ' .
            $orderID . ', ' .
            $addressID . ', "' .
            $status . '", ' .
            $date . ')';
        $queryResult = mysqli_query($connection, $query);
        $n = mysqli_affected_rows($connection);
        $db->closeDbConnection();
        if ($n) {
            return $shippingID;
        } else {
            return false;
        }
    }
}

?>