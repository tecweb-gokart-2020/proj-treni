<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../includes/resources.php";
use DBAccess;
use function ACCOUNT\edit_mail;
use function ACCOUNT\edit_pw;

session_start();
$newMail = &$_POST["email"];
$newPw = &$_POST["password"];

if(isset($_SESSION["username"]) and (isset($newMail) or isset($newPw))) {
    if(isset($newMail)) {
        $result = edit_mail($_SESSION["username"], $newMail);
        $emailDone = false;
        if($result) {
            $emailDone = true;
        }
    }
    if(isset($newPw)) {
        $result = edit_pw($_SESSION["username"], $newPw);
        $pwDone = false;
        if($result) {
            $pwDone = true;
        }
    }
    include "info.php";
} else {
    header("Location: info.php");
}
?>
