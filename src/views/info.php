<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../includes/resources.php";
use DB\DBAccess;
use function ACCOUNT\getEmailOfAccount;
use function ACCOUNT\getPasswordOfAccount;

session_start();
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
    /* Contenuto reale della pagina */
    $user = $_SESSION["username"];
    $email = getEmailOfAccount($user);
    $password =  getPasswordOfAccount($user);
    echo "<h2>Benvenuto $user!</h2>"
        . PHP_EOL .
        "<form action=\"\"><fieldset><legend>Email e password</legend>"
        . PHP_EOL .
        "<label for=\"email\">email:</label>"
        . PHP_EOL .
        "<input name=\"email\" id=\"email\" value=\"$email\" maxlength=\"50\"/>"
        . PHP_EOL .
        "<label for=\"password\">password:</label>"
        . PHP_EOL .
        "<input type=\"password\" name=\"password\" id=\"password\" value=\"$password\" maxlength=\"50\"/>"
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
