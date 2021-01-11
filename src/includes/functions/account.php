<?php
namespace ACCOUNT;
require_once __DIR__ . DIRECTORY_SEPARATOR . '../resources.php';
use mysqli;
use Exception;
use DB\DBAccess;
use function UTILITIES\check_email;
use function UTILITIES\username_exists;
use function UTILITIES\email_exists;

/* Ritorna gli ordini di un account sotto forma di array, NULL se
 * non ne ha */
function getOrdersFromAccount($username) {
    $db = new DBAccess();
    $connection = $db->openDbConnection();

    $query = "SELECT orderID FROM ordine WHERE username = \"" . $username . "\";";
    $result = mysqli_query($connection,$query);
    $final = mysqli_fetch_array($result, MYSQLI_NUM);

    $db->closeDbConnection();
    return $final;
}

/* Ritorna gli indirizzi di un account sotto forma di array, NULL se
 * non ne ha */
function getAddressesFromAccount($username) {
    $db = new DBAccess();
    $connection = $db->openDbConnection();

    $query = "SELECT addressID FROM indirizzo WHERE username = \"" . $username . "\";";
    $result = mysqli_query($connection,$query);
    $final = mysqli_fetch_array($result, MYSQLI_NUM);

    $db->closeDbConnection();
    return $final;
}

function getEmailOfAccount($username) {
    $db = new DBAccess();
    $connection = $db->openDbConnection();

    $query = "SELECT email FROM utente WHERE username = \"" . $username . "\";";
    $result = mysqli_query($connection,$query);
    $final = mysqli_fetch_array($result, MYSQLI_NUM)[0];

    $db->closeDbConnection();
    return $final;
}

function getPasswordOfAccount($username) {
    $db = new DBAccess();
    $connection = $db->openDbConnection();

    $query = "SELECT password FROM utente WHERE username = \"" . $username . "\";";
    $result = mysqli_query($connection,$query);
    $final = mysqli_fetch_array($result, MYSQLI_NUM)[0];

    $db->closeDbConnection();
    return $final;
}

/* Ritorna il carrello di un account, NULL se non ce l'ha */
function getCartFromAccount($username) {
    $db = new DBAccess();
    $connection = $db->openDbConnection();

    $query = "SELECT cartID FROM utente WHERE username = \"" . $username . "\";";
    $result = mysqli_query($connection,$query);
    $final = mysqli_fetch_array($result, MYSQLI_NUM);

    $db->closeDbConnection();
    return $final[0];
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

    /* FizzBuzz con mail e account */
    if(!$valid_email) {
        $error_str .= "Email non valida: " . $email . PHP_EOL;
    }
    if(!$valid_username) {
        $error_str .= "Username deve avere almeno 3 caratteri" . PHP_EOL;
    }
    if(username_exists($username)) {
        $error_str .= "Username già presente: " . $username . PHP_EOL;
    }
    if(email_exists($email)) {
        $error_str .= "email già presente: " . $email . PHP_EOL;
    }
    if($error_str !== "") {
        throw new Exception($error_str);
    }

    // Occhio che se non è settata va tutto in mona!!
    $cartID = $_SESSION["cartID"];

    $db = new DBAccess();
    $connection = $db->openDbConnection();
    if ($connection->connect_error) {
        throw new Exception("Connection failed: " . $connection->connect_error);
    } 

    $query = "INSERT INTO utente(email, username, password, cartID) VALUES ?, ?, ?, ?";
    $stmt = mysqli_prepare($connection, $query);

    mysqli_stmt_bind_param($stmt, "ssssi", $email, $username, $password, $cartID);
    mysqli_stmt_execute($stmt);
    $to_return = (mysqli_affected_rows($connection) == 1) ? $username : NULL;

    mysqli_stmt_close($stmt);
    $db->closeDbConnection();
    
    return $to_return;
}

/* PRE = UUID e password sono stringhe */ 
/* POST = ritorna username se uuid era username o email di un account
 * e la password era corretta, NULL altrimenti */
/* Lancia eccezione se la connessione al DB non è apribile*/
function login($UUID, $password) {
    $is_email = check_email($UUID);
    $id = $is_email ? "email" : "username";
    
    $db = new DBAccess();
    $connection = $db->openDbConnection();
    // non molto elegante
    if ($connection->connect_error) {
        throw new Exception("Connection failed: " . $connection->connect_error);
    } 

    $query = "SELECT username FROM utente WHERE " . $id . " = ? AND password = ?";
    $stmt = mysqli_prepare($connection, $query);

    mysqli_stmt_bind_param($stmt, "ss", $UUID, $password);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $result);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
    
    $db->closeDbConnection();
    return $result;
}
?>
