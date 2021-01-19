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
$_SESSION["username"] = "user";
$_SESSION["cartID"] = getCartFromAccount($_SESSION["username"]);
if(isset($_SESSION["username"])) {
    /* Se l'utente è autenticato mostrerà la pagina giusta, farà
     * invece un redirect alla home se non lo è (caso in cui l'utente
     * richiede la pagina direttamente da url, invece che dalla home
     * dopo il login) */

    $tag_info = "<span class=\"current_link\">";
    $pagetitle = "Trenogheno - Area personale";
    $pagedescription = "Area dove è possibile gestire i propri dati";
    include "template/header.php";

    $current_page = "area personale >> email e password";
    include "template/breadcrumb.php";
    
    $tag_info = "<span class=\"current_link\">";
    include "template/ap_navbar.php";

    echo '<main id="content">' . PHP_EOL;
    $newMail = &$_POST["email"];
    $newPw = &$_POST["password"];
    
    if(isset($_SESSION["username"]) and (isset($newMail) or isset($newPw))) {
        if(isset($newMail)) {
	    try {
                $result = edit_mail($_SESSION["username"], $newMail);
	    } catch (Exception $e) {
	    	echo "eccezione email volata!" . $e->getMessage() . PHP_EOL;
	    }
            $emailDone = false;
            if($result) {
                $emailDone = true;
            }
        }
        if(isset($newPw)) {
	    try {
                $result = edit_pw($_SESSION["username"], $newPw);
	    } catch (Exception $e) {
	    	echo "eccezione pw volata!" . $e->getMessage() . PHP_EOL;
	    }
            $pwDone = false;
            if($result) {
                $pwDone = true;
            }
        }
    }
    /* Contenuto reale della pagina */
    $user = $_SESSION["username"];
    $email = getEmailOfAccount($user);
    $password =  getPasswordOfAccount($user);
    echo "<h2>Benvenuto $user!</h2>"
        . PHP_EOL .
        '<form action="info.php" method="post"><fieldset><legend>Email e password</legend>'
        . PHP_EOL .
        "<label for=\"email\">email:</label>"
        . PHP_EOL .
        "<input name=\"email\" id=\"email\" value=\"$email\" maxlength=\"50\"/>"
        . PHP_EOL .
        "<label for=\"password\">password:</label>"
        . PHP_EOL .
        "<input type=\"password\" name=\"password\" id=\"password\" value=\"$password\" maxlength=\"50\"/>"
        . PHP_EOL .
        '<input id="filtroSubmit" type="submit" name="submit" value="Modifica email" />'
        . PHP_EOL .
        "</fieldset></form>"
        . PHP_EOL;

    if(isset($emailDone)) {
        if($emailDone) {
            echo '<h3><span xml:lang="en" lang="en">Email</span> modificata con successo</h3>';
        }
        else {
            echo '<h3><span xml:lang="en" lang="en">Email</span> non valida</h3>';
        }
        unset($emailDone);
    }
    if(isset($pwDone)) {
        if($pwDone) {
            echo '<h3><span xml:lang="en" lang="en">Password</span> modificata con successo</h3>';
        }
        else {
            echo '<h3><span xml:lang="en" lang="en">Password</span> non valida</h3>';
        }
        unset($pwDone);
    }

    echo '</main>' . PHP_EOL;
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
