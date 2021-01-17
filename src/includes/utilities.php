<?php
namespace UTILITIES;
require_once __DIR__ . DIRECTORY_SEPARATOR . 'resources.php';
use mysqli;
use DB\DBAccess;

function isValidID($id){
    $reg_expr = "/^\d+$/";
    if(preg_match($reg_expr,$id)!=0){
        return true;
    }else{
        error_log("Invalid ID! Must be a number");
        return false;
    }
}
/* Filtro per validare email, combinazione di FILTER_VALIDATE_EMAIL e
 * una regexp un po'più stringente */
function check_email($email) {
    if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return preg_match("/^(\w{3,})@(\w{3,}).(\d{2,})*$/", $email);
    }
    return false;
}

/* true se esiste, false altrimenti */
function email_exists($email) {
    $db = new DBAccess();
    $connection = $db->openDbConnection();
    $query = "SELECT email FROM utente WHERE email = ?";
    $stmt = mysqli_prepare($connection, $query);

    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $result);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    $db->closeDbConnection();
    return (mysqli_num_rows($result) == 0);
}

/* true se esiste, false se non esiste */
function username_exists($username) {
    $db = new DBAccess();
    $connection = $db->openDbConnection();

    $query = "SELECT username FROM utente WHERE username = ?";
    $stmt = mysqli_prepare($connection, $query);

    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $result);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    $db->closeDbConnection();
    return (mysqli_num_rows($result) == 0);
}

/* Sta roba prende il tag definito da quello sopra e imposta quello di
chiusura */
function init_tag(&$tag, $default, &$tag_close) {
    if(!isset($tag)) {
        $tag = $default;
    }
    if($tag != ""){
        preg_match('/^<\w{1,}/', $tag, $tmp);
        preg_match('/\w{1,}/', $tmp[0], $tmp);
        $tag_close = "</" . $tmp[0] . ">";
    }
    else {
        $tag_close = "";
    }
}

?>
