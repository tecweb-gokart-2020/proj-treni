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

/* address mappa che rappresenta un indirizzo, se l'indirizzo è
 * presente nel db va tornato l'id, false altrimenti */
function address_exists($address) {
    $db = new DBAccess();
    $connection = $db->openDbConnection();
    $query = 'SELECT addresID FROM indirizzo WHERE nome=?, cognome=?, via=?, civico=?, citta=?, provincia=?, cap=?, stato=?, telefono=?';
    if(myqli_stmt_prepare($stmt, $query)){
        mysqli_stmt_bind_param($stmt, 'sssssssss', 
                               $address["nome"],
                               $address["cognome"],
                               $address["via"],
                               $address["civico"],
                               $address["citta"],
                               $address["provincia"],
                               $address["cap"],
                               $address["stato"],
                               $address["telefono"]);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $res);
        mysqli_stmt_fetch($stmt);
        return $res;
    }
    return false;
}


/* Address è una mappa che riporta le informazioni du un indirizzo. se
 * questo già esiste ritorna l'id, altrimenti lo inserisce e ne
 * ritorna l'id. ritorna false se la mappa è errata (campi non
 * validi) */
function getAddress($address){
    if($ID = address_exists($address)){
        return $ID;
    } else {
        $db = new DBAccess();
        $connection = $dbAccess->openDbConnection();
        $query = "SELECT addressID FROM indirizzo ORDER BY addressID DESC LIMIT 1";
        $queryResult = mysqli_query($connection, $query);
        $addressID = mysqli_fetch_row($queryResult)[0] + 1;
        //mamma mia che casino
        $query = 'INSERT INTO indirizzo(addressID, nome, cognome, via, civico, citta, provincia, cap, stato, telefono) VALUES ('.
               $addressID . ', ' .
               address["nome"] . ', ' .
               address["cognome"] . ', ' .
               address["via"] . ', ' .
               address["civico"] . ', ' .
               address["citta"] . ', ' .
               address["provincia"] . ', ' .
               address["cap"] . ', ' .
               address["stato"] . ', ' .
               address["telefono"] . ')';
        $queryResult = mysqli_query($connection, $query);
        $db->closeDbConnection();
        if($queryResult) {
            return $addressID;
        }
        else {
            return false;
        }
    }
}
?>
