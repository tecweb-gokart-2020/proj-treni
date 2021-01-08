<?php
namespace ORDINE;
require_once __DIR__ . DIRECTORY_SEPARATOR . '../resources.php';
use DB\DbAccess;
use function UTILITIES\isValidID;

// Ritorna la data in cui è stato fatto un ordine dato il suo ID, null se l'ordine non esiste
function getDateFromOrder($order_id){
    if(isValidID($order_id)){
        $dbAccess = new DBAccess();
        $connection = $dbAccess->openDbConnection();
        $query = "SELECT data_ordine FROM ordine WHERE orderID = \"$order_id\"";
        $queryResult = mysqli_query($connection, $query);
        $dbAccess->closeDbConnection();
        $data_ordine = mysqli_fetch_row($queryResult);
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
        $dbAccess->closeDbConnection();
        $totale = mysqli_fetch_row($queryResult);
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
        $query = "SELECT shippingID, quantita, stato, prezzo_netto FROM prodotto_ordinato WHERE orderID = \"$order_id\"";
        $queryResult = mysqli_query($connection, $query);
        $listaProdotti = array();
        if(mysqli_num_rows($queryResult)!=0){
            while($riga = mysqli_fetch_assoc($queryResult)){
                $singoloProdotto = array(
                    "IDSpedizione", $riga["shippingID"],
                    "Qta", $riga["quantita"],
                    "Stato", $riga["stato"],
                    "Prezzo acquisto", $riga["prezzo_netto"]
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