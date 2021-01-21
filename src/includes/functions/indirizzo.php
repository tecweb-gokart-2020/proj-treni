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
    $query = 'SELECT addresID FROM indirizzo WHERE nome="'. $address["nome"] . 
           '", cognome="'. $address["cognome"] . 
           '", via="'. $address["via"] . 
           '", civico="'. $address["civico"] . 
           '", citta="'. $address["citta"] . 
           '", provincia="'. $address["provincia"] . 
           '", cap="'. $address["cap"] . 
           '", stato="'. $address["stato"] . 
           '", telefono="'. $address["telefono"] . '"';
    $res = mysqli_query($connection, $query);
    if($res){
        return mysqli_affected_rows($res);
    }
    return false;
}


/* Address è una mappa che riporta le informazioni du un indirizzo. se
 * questo già esiste ritorna l'id, altrimenti lo inserisce e ne
 * ritorna l'id. ritorna false se la mappa è errata (campi non
 * validi) */
function getAddress($address, $user){
    $ID = address_exists($address);
    if($ID){
        return $ID;
    } else {
        $db = new DBAccess();
        $connection = $db->openDbConnection();
        $query = "SELECT addressID FROM indirizzo ORDER BY addressID DESC LIMIT 1";
        $queryResult = mysqli_query($connection, $query);
        $addressID = mysqli_fetch_row($queryResult)[0] + 1;
        //mamma mia che casino
	$query = 'INSERT INTO indirizzo(username, nome, cognome, via, numero, citta, provincia, cap, stato, telefono) VALUES ('.
               $user . ', ' .
               $address["nome"] . ', ' .
               $address["cognome"] . ', ' .
               $address["via"] . ', ' .
               $address["numero"] . ', ' .
               $address["citta"] . ', ' .
               $address["provincia"] . ', ' .
               $address["cap"] . ', ' .
               $address["stato"] . ', ' .
               $address["telefono"] . ')';
        $queryResult = mysqli_query($connection, $query);
	var_dump($queryResult);
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
