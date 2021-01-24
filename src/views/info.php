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

    $tag_info = "";
    $pagetitle = "trenene - Area personale";
    $pagedescription = "Area dove è possibile gestire i propri dati";
    $js = '<script type="text/javascript" src="js/info.js"></script>';
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
    echo '<div id="areaPersonale"><h2>Benvenuto '. $user.'!</h2>'
        . PHP_EOL .
        '<form id="form" action="info.php" method="post" novalidate aria-live="assertive"><fieldset><legend>Email</legend>'
        . PHP_EOL .
        '<label for="oldMail">Vecchia mail:</label>'
        . PHP_EOL .
	'<input name="oldMail" id="oldMail" maxlength="50" autocomplete="on" aria-errormessage="errorOldEmail" aria-invalid="false" required/><br/>'
    . PHP_EOL .
    '<div id="errorOldEmail" class="errore" >Per cambiare indirizzo email, inserisci quello attuale</div>'
	. PHP_EOL .
        '<label for="newMail">Nuova mail:</label>'
        . PHP_EOL .
	'<input name="newMail" id="newMail" maxlength="50" autocomplete="on" aria-errormessage="errorNewEmail" aria-invalid="false" required/><br/>'
    . PHP_EOL .
    '<div id="errorNewEmail" class="errore" >Inserisci un indirizzo email valido e diverso da quello attuale</div>'
	. PHP_EOL .
        '<label for="reMail">Conferma mail:</label>'
        . PHP_EOL .
	'<input name="reMail" id="reMail" maxlength="50" autocomplete="on" aria-errormessage="errorReEmail" aria-invalid="false" required/><br/>'
    . PHP_EOL .
    '<div id="errorReEmail" class="errore" >Gli indirizzi email non coincidono</div>'
	. PHP_EOL .
	'<button type="submit" name="edit" id="editEmail" value="email">modifica email</button></fieldset></form>'
        . PHP_EOL .
        '<form action="info.php" method="post"><fieldset><legend>Password</legend>'
        . PHP_EOL .
        '<label for="oldPassword">Vecchia password:</label><input type="password" name="oldPassword" id="oldPassword" maxlength="50" autocomplete="on" aria-errormessage="errorOldPassword" aria-invalid="false" required/><br/>'
        . PHP_EOL .
    '<div id="errorOldPassword" class="errore" >Per cambiare password, inserisci quella attuale</div>'
        . PHP_EOL .
        '<label for="newPassword">Nuova password :</label><input type="password" name="newPassword" id="newPassword" maxlength="50" aria-errormessage="errorNewPassword" aria-invalid="false" required/><span> <em>non usare</em> /\,.:;\'><</span><br/>'
        . PHP_EOL .
    '<div id="errorNewPassword" class="errore" >Inserisci una password valida e diversa da quella attuale</div>'
        . PHP_EOL .
        '<label for="rePassword">Conferma password:</label><input type="password" name="rePassword" id="rePassword" maxlength="50" aria-errormessage="errorRePassword" aria-invalid="false" required/><br/>'
        . PHP_EOL .
    '<div id="errorRePassword" class="errore" >Le password non coincidono</div>'
        . PHP_EOL .
        '<label><input id="mostraPassword" type="checkbox">Mostra password</label><br/>'
        . PHP_EOL .
        '<button type="submit" name="edit" id="editPw" value="password">Modifica password</button>'
        . PHP_EOL .
        '</fieldset></form><div id="logoutContainer"><a id="logout" href="logout.php">Logout</a></div>'
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
