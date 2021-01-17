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

    $tag_info = "<span class=\"current_link\">"
    include "template/header.php";

    $tag_info = "<span class=\"current_link\">"
    include "template/ap_navbar.php";

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

    include "template/footer.php";
}
else {
    /* Se l'utente non è impostato -> l'utente deve loggarsi ->
     * redirect alla pagina di login */
    header("Location: login.html");
    exit();
}
?>
