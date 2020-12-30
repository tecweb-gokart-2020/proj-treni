<?php
namespace ACCOUNT;

/* Ritorna gli ordini di un account sotto forma di array, NULL se
 * non ne ha */
function getOrdersFromAccount($accountID) {
    $db = new DBAccess();
    $connection = $db->openDbConnection();

    $query = "SELECT orderID FROM ordine WHERE accountID = " . $accountID;
    $result = mysqli_query($query);
    $final = mysqli_fetch_array($result, MYSQLI_NUM);

    $db->closeDbConnection();
    return $final;
}

/* Ritorna gli indirizzi di un account sotto forma di array, NULL se
 * non ne ha */
function getAddressesFromAccount($accountID) {
    $db = new DBAccess();
    $connection = $db->openDbConnection();

    $query = "SELECT addressID FROM indirizzo WHERE accountID = " . $accountID;
    $result = mysqli_query($query);
    $final = mysqli_fetch_array($result, MYSQLI_NUM);

    $db->closeDbConnection();
    return $final;
}

/* Ritorna il carrello di un account, NULL se non ce l'ha */
function getCartFromAccount($accountID) {
    $db = new DBAccess();
    $connection = $db->openDbConnection();

    $query = "SELECT cartID FROM utente WHERE accountID = " . $accountID;
    $result = mysqli_query($query);
    $final = mysqli_fetch_array($result, MYSQLI_NUM);

    $db->closeDbConnection();
    return $final;
}

function check_email($email) {
    if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
        if(preg_match("", $email)) {
            return true;
        }
    }
    return false;
}

function check_username($username) {
    
}

function check_password($password) {
    
}

function register($email, $username, $password) {
    check_email($email);
    check_username($username);
    check_password($password);
}
?>
