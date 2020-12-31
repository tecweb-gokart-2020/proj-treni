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

/* Inserisce in database un utente con email e password specificate,
 * fa sanity check sulle cose e dovrebbe evitare sql injection tramire
 * mysqli_prepare. */
/* PRE = username, email e password sono tre stringhe e la variabile
 * $_SESSION["cartID"] è ben formata */
/* POST = ritorna l'ID del nuovo utente se è andato tutto bene, lancia
 * invece un'eccezione che indica cosa è andato storto altrimenti */

function register($email, $username, $password) {
    $valid_email = check_email($email);
    $valid_username = preg_match("/\w{3,}/", $username);

    $error_str = "";

    if(!$valid_email) {
        $error_str .= "Email non valida: " . $email . PHP_EOL;
    }
    if(username_exixst($username)) {
        $error_str .= "Username già presente: " . $username . PHP_EOL;
    }
    if(!$valid_username) {
        $error_str .= "Username deve avere almeno 3 caratteri" . PHP_EOL;
    }
    if($error_str !== "") {
        throw new Exception(error_str);
    }

    $cartID = $_SESSION["cartID"];

    $db = new DBAccess();
    $connection = $db->openDbConnection();
    // non molto elegante
    if ($connection->connect_error) {
        error_log("Connection failed: " . $connection->connect_error);
        return NULL;
    } 

    $query = "INSERT INTO utente(email, UUID, password, cartID) VALUES ?, ?, ?, ?";
    $stmt = mysqli_prepare($connection, $query);

    mysqli_stmt_bind_param($stmt, "ssssi", $ID, $email, $username, $password, $cartID);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $result);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
    
    $db->closeDbConnection();
    return TRUE;
}

/* PRE = UUID e password sono stringhe */ 
/* POST = ritorna accountID se uuid era username o email di un account
 * e la password era corretta, NULL altrimenti */
function login($UUID, $password) {
    $is_email = check_email($UUID);
    $id = $is_email ? "email" : "username";
    
    $db = new DBAccess();
    $connection = $db->openDbConnection();
    // non molto elegante
    if ($connection->connect_error) {
        error_log("Connection failed: " . $connection->connect_error);
        return NULL;
    } 

    $query = "SELECT ID FROM utente WHERE " . $id . " = ? AND password = ?";
    $stmt = mysqli_prepare($connection, $query);

    mysqli_stmt_bind_param($stmt, "ss", $UUID, $password);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $result);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
    
    $db->closeDbConnection();
    if(mysqli_stmt_fetch($stmt)) {
        return $result;
    };
    return NULL;
}
?>
