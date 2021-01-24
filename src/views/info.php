<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../includes/resources.php";
use DB\DBAccess;
use function ACCOUNT\getEmailOfAccount;
use function ACCOUNT\getPasswordOfAccount;
use function ACCOUNT\getCartFromAccount;
use function ACCOUNT\edit_pw;
use function ACCOUNT\edit_mail;

session_start();
//debug
// $_SESSION["username"] = "user";
// $_SESSION["cartID"] = getCartFromAccount($_SESSION["username"]);
if(isset($_SESSION["username"])) {
    /* Se l'utente è autenticato mostrerà la pagina giusta, farà
     * invece un redirect alla home se non lo è (caso in cui l'utente
     * richiede la pagina direttamente da url, invece che dalla home
     * dopo il login) */

    $tag_info = "<span class=\"current_link\">";
    $pagetitle = "trenene - Area personale";
    $pagedescription = "Area dove è possibile gestire i propri dati";
    include "template/header.php";

    $current_page = "area personale >> email e password";
    include "template/breadcrumb.php";
    
    $tag_info = "<span class=\"current_link\">";
    include "template/ap_navbar.php";

    echo '<main id="content">' . PHP_EOL;
    $newMail = &$_POST["newMail"];
    $oldMail = &$_POST["oldMail"];
    $reMail = &$_POST["reMail"];
    $newPw = &$_POST["newPassword"];
    $rePw = &$_POST["rePassword"];
    $oldPw = &$_POST["oldPassword"];
    
    if(isset($_SESSION["username"])) {
        if($_POST["edit"] == "email" and isset($newMail) and isset($oldMail) and isset($reMail)) {
            $emailDone = edit_mail($_SESSION["username"], $oldMail, $newMail, $reMail);
        }
        if($_POST["edit"] == "password" and isset($newPw) and isset($oldPw) and isset($rePw)) {
            $pwDone = edit_pw($_SESSION["username"], $oldPw, $newPw, $rePw);
        }
    }
    /* Contenuto reale della pagina */
    $user = $_SESSION["username"];
    $email = getEmailOfAccount($user);
    $password =  getPasswordOfAccount($user);
    echo '<div id="areaPersonale"><h1>Benvenuto '. $user.'!</h2>'
        . PHP_EOL .
        '<form action="info.php" method="post"><fieldset><legend>Email</legend>'
        . PHP_EOL .
        '<label for="oldMail">vecchia mail:</label>'
        . PHP_EOL .
	'<input name="oldMail" id="oldMail" maxlength="50"/>'
	. PHP_EOL .
        '<label for="newMail">nuova mail:</label>'
        . PHP_EOL .
	'<input name="newMail" id="newMail" maxlength="50"/>'
	. PHP_EOL .
        '<label for="reMail">conferma mail:</label>'
        . PHP_EOL .
	'<input name="reMail" id="reMail" maxlength="50"/>'
	. PHP_EOL .
	'<button type="submit" name="edit" id="editEmail" value="email">modifica email</button></fieldset>'
        . PHP_EOL .
        '<fieldset><legend>Password</legend>'
        . PHP_EOL .
        '<label for="oldPassword">vecchia password:</label><input type="password" name="oldPassword" id="oldPassword" maxlength="50"/>'
        . PHP_EOL .
        '<label for="newPassword">nuova password:</label><input type="password" name="newPassword" id="newPassword" maxlength="50"/>'
        . PHP_EOL .
        '<label for="rePassword">conferma password:</label><input type="password" name="rePassword" id="rePassword" maxlength="50"/>'
        . PHP_EOL .
        '<button type="submit" name="edit" id="editPw" value="password">modifica password</button>'
        . PHP_EOL .
        '</fieldset></form>'
        . PHP_EOL;

    if(isset($emailDone)) {
        if($emailDone === true) {
            echo '<h3><span xml:lang="en" lang="en">Email</span> modificata con successo</h3>';
        }
        else if($emailDOne === 0){
            echo '<h3><span xml:lang="en" lang="en">Email</span> non valida o già in memoria</h3>';
        }
        else if($emailDOne === 2){
            echo '<h3>vecchia <span xml:lang="en" lang="en">email</span> sbagliata</h3>';
        }
        else if($emailDOne === 3){
            echo '<h3>Le <span xml:lang="en" lang="en">email</span> non coincidono</h3>';
        }
        unset($emailDone);
    }
    if(isset($pwDone)) {
        if($pwDone === true) {
            echo '<h3><span xml:lang="en" lang="en">Password</span> modificata con successo</h3>';
        }
        else if($pwDone === 0){
            echo '<h3><span xml:lang="en" lang="en">Password</span> non valida, vecchia password errata</h3>';
        }
        else if($pwDone === 2){
            echo '<h3><span xml:lang="en" lang="en">Password</span> non valida, le password non coincidono</h3>';
        }
        unset($pwDone);
    }

    echo '</div></main>' . PHP_EOL;
    include "template/footer.php";
}
else {
    /* Se l'utente non è impostato -> l'utente deve loggarsi ->
     * redirect alla pagina di login */
    $host  = $_SERVER['HTTP_HOST'];
    $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $extra = 'login.php';
    header("Location: http://$host$uri/$extra");
    exit();
}
?>
