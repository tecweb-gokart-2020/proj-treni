<?php
namespace SESSION;

/* ritorna NULL se non c'è nessun account collegato alla sessione,
 * ritorna l'id dell'account se questo esiste */
function getAccountID($sessionID) {
    $db = new DBAccess();
    $connection = $db->openDbConnection();

    $query = "SELECT accountID FROM sessione_utente WHERE sessionID is " . $sessionID;
    $result = mysqli_query($query);
    if(mysqli_num_rows($result) == 0) {
        return NULL;
    }
    $final = mysqli_fetch_array($result, MYSQLI_ASSOC)["accountID"];
    $db->closeDbConnection();
    return $final;
}

/* Ritorna NULL se la sessione non ha nessun carrello associato
 * (dovrebbe essere un errore), ritorna un array con i carrelli legati
 * alla sessione altrimenti */
function getCartID($sessionID) {
    $db = new DBAccess();
    $connection = $db->openDbConnection();
    
    $query = "SELECT cartID FROM carrello WHERE sessionID is " . $sessionID;
    $result = mysqli_query($query);
    if(mysqli_num_rows($result) == 0) {
        return NULL;
    }
    $final = mysqli_fetch_array($result, MYSQLI_NUM);
    $db->closeDbConnection();
    return $final;
}

/* Associa alla sessione $sessionID l'acocunt $accountID, se tutto va
 * bene ritorna true, altrimenti ritorna false */
function associateAccount($sessionID, $accountID) {
    $db = new DBAccess();
    $connection = $db->openDbConnection();

    $account = getAccountID($sessionID);
    
    if($account != NULL) {
        return false;
    } else {
        $query = "UPDATE sessione_utente SET accountID = " . $accountID . " WHERE sessionID = " . $sessionID;
        $result = mysqli_query($query);
    }
    
    $db->closeDbConnection();
    return true;
}
?>
