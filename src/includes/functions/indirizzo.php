<?php
namespace INDIRIZZO;
require_once __DIR__ . DIRECTORY_SEPARATOR . '../resources.php';
use DB\DbAccess;
use function UTILITIES\isValidID;

// Ritorna l'ID dell'account associato ad un indirizzo, null se non esiste
function getAccountFromAddress($address_id){
    if(isValidID($address_id)){
        $dbAccess = new DBAccess();
        $connection = $dbAccess->openDbConnection();
        $query = "SELECT username FROM indirizzo WHERE addressID = \"$address_id\"";
        $queryResult = mysqli_query($connection, $query);
        $dbAccess->closeDbConnection();
        $account_id = mysqli_fetch_row($queryResult);
        return $account_id;
    }else{
        return false;
    }
}

// Ritorna un array associativo con i campi presenti in un indirizzo, null se non c'è alcun indirizzo
function getInfoFromAddress($address_id){
    if(isValidID($address_id)){
        $dbAccess = new DBAccess();
        $connection = $dbAccess->openDbConnection();
        $query = "SELECT nome, via, numero, citta, stato, provincia, cap, telefono
                  FROM indirizzo WHERE addressID = \"$address_id\"";
        $queryResult = mysqli_query($connection, $query);
        $infoIndirizzo = mysqli_fetch_assoc($queryResult);
        $dbAccess->closeDbConnection();
        return $infoIndirizzo;
    }else{
        return false;
    }
}

?>
