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

function register($email, $username, $password) {
    $valid_email = check_email($email);
    $valid_username = check_username($username);
    $valid_password = check_password($password);

    $error_str = "";

    if($valid_email) {
        
    } else {
        $error_str .= "Email non valida: " . $email;
    }
    if($valid_username) {
        
    } else {
        $error_str .= " Username non valido" . $username;
    }
    if($valid_password) {
        
    } else {
        $error_str .= "Password non valida" . $password;
    }
    if($error_str === "") {
        error_log(error_str);
        return NULL;
    }

    $cartID = $_SESSION["cartID"];

    $db = new DBAccess();
    $connection = $db->openDbConnection();

    $sep = ", ";
    $query = "INSERT INTO utente(email, username, password, cartID) VALUES " .
           $email . $sep . $username . $sep . $password . $sep . $cartID;
    $result = mysqli_query($query);
    
}
?>
