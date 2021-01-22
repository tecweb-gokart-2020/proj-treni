<?php
namespace UTILITIES;
require_once __DIR__ . DIRECTORY_SEPARATOR . 'resources.php';
use mysqli;
use DB\DBAccess;

function isValidID($id){
    $reg_expr = "/^\d+$/";
    $res = preg_match($reg_expr,$id);
    if($res != false or $res === 0){
        return true;
    }else{
	    error_log("ERROR: " . $id . " Must be a valid ID");
	    return false;
    }
}
/* Filtro per validare email, combinazione di FILTER_VALIDATE_EMAIL e
 * una regexp un po'più stringente */
function check_email($email) {
    if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return preg_match("/^\w+[+.\w-]*@([\w-]+.)*\w+[\w-]*.([a-z]{2,4}|d+)$/i", $email);
    }
    return false;
}

/* true se esiste, false altrimenti */
function email_exists($email) {
    $db = new DBAccess();
    $connection = $db->openDbConnection();
    cleanUp($email);
    $query = "SELECT email FROM utente WHERE email = \"$email\"";
    $res = mysqli_query($connection, $query);

    $db->closeDbConnection();
    return (mysqli_num_rows($res) > 0);
}

/* true se esiste, false se non esiste */
function username_exists($username) {
    $db = new DBAccess();
    $connection = $db->openDbConnection();

    $query = "SELECT username FROM utente WHERE username = \"$username\"";
    $result = mysqli_query($connection, $query);

    $db->closeDbConnection();
    return (mysqli_num_rows($result) > 0);
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

//pulizia base
//toglie spazi vuoti in eccesso, slash e tag
function cleanUp($input){
    $input = trim($input);
    $input = stripslashes($input);
    $input = strip_tags($input);
    $input = preg_replace("/\s+/", " ", $input);
    return $input;
}

//come sopra ma lascia gli slash (es. per il numero civico)
function cleanUp_keepSlashes($input){
    $input = trim($input);
    $input = strip_tags($input);
    $input = preg_replace("/\s+/", " ", $input);
    return $input;
}

//compatta l'input
function removeWhitespaces($input){
    return preg_replace("/\s+/", "", $input);
}
?>
