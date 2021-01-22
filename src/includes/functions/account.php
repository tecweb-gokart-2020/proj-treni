<?php
namespace ACCOUNT;
require_once __DIR__ . DIRECTORY_SEPARATOR . '../resources.php';
use mysqli;
use Exception;
use DB\DBAccess;
use function UTILITIES\check_email;
use function UTILITIES\username_exists;
use function UTILITIES\email_exists;
use function UTILITIES\cleanUp;

/* Ritorna gli ordini di un account sotto forma di array, NULL se
 * non ne ha */
function getOrdersFromAccount($username) {
    $db = new DBAccess();
    $connection = $db->openDbConnection();

    $query = "SELECT orderID FROM ordine WHERE username = \"" . $username . "\";";
    $result = mysqli_query($connection,$query);
    $final = array();
    while($res = mysqli_fetch_row($result)){
	array_push($final, $res[0]);
    }

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

function register($email, $username, $password, $cartID) {
    $valid_email = check_email($email);
    $valid_username = preg_match("/^\w{3,}/", $username);

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

    $db = new DBAccess();
    $connection = $db->openDbConnection();
    if ($connection->connect_error) {
        throw new Exception("Connection failed: " . $connection->connect_error);
    } 

    cleanUp($email);
    cleanUp($username);
    cleanUp($password);

    $query = "INSERT INTO utente(email, username, password, cartID) VALUES (\"$email\", \"$username\", \"$password\", $cartID)";
    $result = mysqli_query($connection, $query);

    $to_return = (mysqli_affected_rows($connection) == 1) ? $username : NULL;

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

    $query = 'SELECT username FROM utente WHERE ' . $id . ' = "'. $UUID .'" AND password = "'. $password . '"';
    $res = mysqli_query($connection, $query);
    $name = mysqli_fetch_row($res);
    
    $db->closeDbConnection();
    return $name[0];
}

/* newMail è una stringa e user è l'id di un utente */
function edit_mail($user, $newMail) {
    $db = new DBAccess();
    $connection = $db->openDbConnection();
    // non molto elegante
    if ($connection->connect_error) {
        throw new Exception("Connection failed: " . $connection->connect_error);
    } 

    if(check_email($newMail) and !email_exists($newMail)) {
        $query = 'UPDATE utente SET email=? WHERE username=?';
        $stmt = mysqli_prepare($connection, $query);
        
        mysqli_stmt_bind_param($stmt, "ss", $newMail, $user);
        mysqli_stmt_execute($stmt);
        $rows = mysqli_stmt_affected_rows($stmt);
        mysqli_stmt_close($stmt);
        
        $db->closeDbConnection();
        return $rows == 1;
    }
    return false;
}

/* newPw è una stringa e user è l'id di un utente */
function edit_pw($user, $oldPw, $newPw, $rePw) {
    $db = new DBAccess();
    $connection = $db->openDbConnection();
    // non molto elegante
    if ($connection->connect_error) {
        throw new Exception("Connection failed: " . $connection->connect_error);
    } 

    if($oldPw === getPasswordOfAccount($user)){
	    if($newPw === $rePw) {
        	$query = 'UPDATE utente SET password = ? WHERE username = ?';
        	$stmt = mysqli_prepare($connection, $query);
        
        	mysqli_stmt_bind_param($stmt, "ss", $newPw, $user);
        	mysqli_stmt_execute($stmt);
        	$rows = mysqli_stmt_affected_rows($stmt);
        	mysqli_stmt_close($stmt);
        
        	$db->closeDbConnection();
     	   	return $rows == 1;
	    }
	    else {
	    	return 2;
	    }
    }
    else {
    	return 0;
    }
    return false;
}
?>
