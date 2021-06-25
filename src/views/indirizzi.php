<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . "../includes/resources.php";

use function ACCOUNT\getAddressesFromAccount;
use function INDIRIZZO\getInfoFromAddress;

function printAddress($addressID)
{
    $addr = getInfoFromAddress($addressID);
    if ($addr) {
        echo '<ul class="display-address">' . PHP_EOL;
        echo '<li class="nome">' . $addr["nome"] . "</li>" . PHP_EOL;
        echo '<li class="via">' . $addr["via"] . "</li>" . PHP_EOL;
        echo '<li class="numero">' . $addr["numero"] . "</li>" . PHP_EOL;
        echo '<li class="citta">' . $addr["citta"] . "</li>" . PHP_EOL;
        echo '<li class="stato">' . $addr["stato"] . "</li>" . PHP_EOL;
        echo '<li class="comune">' . $addr["comune"] . "</li>" . PHP_EOL;
        echo '<li class="cap">' . $addr["cap"] . "</li>" . PHP_EOL;
        echo '</ul>' . PHP_EOL;
    } else {
        echo "Indirizzo non valido, qualcosa è andato storto...";
    }
}

session_start();
if (isset($_SESSION["username"])) {
    /* Se l'utente è autenticato mostrerà la pagina giusta, farà
     * invece un redirect alla home se non lo è (caso in cui l'utente
     * richiede la pagina direttamente da url, invece che dalla home
     * dopo il login) */

    $tag_info = "<span class=\"current_link\">";
    include "template/header.php";

    $current_page = "indirizzi";
    include "template/breadcrumb.php";

    $tag_indirizzi = "<span class=\"current_link\">";
    include "template/ap_navbar.php";

    echo '<main id="content">' . PHP_EOL;
    $addresses = getAddressesFromAccount($_SESSION["username"]);
    echo "<ul id=\"address-list\">" . PHP_EOL;
    foreach ($addresses as $address) {
        echo "<li >" . PHP_EOL;
        printAddress($address);
        echo "</li>" . PHP_EOL;
    }
    echo "</ul>" . PHP_EOL;
    echo '</main>';
    include "template/footer.php";
} else {
    /* Se l'utente non è impostato -> l'utente deve loggarsi ->
     * redirect alla pagina di login */
    $host  = $_SERVER['HTTP_HOST'];
    $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $extra = 'login.php';
    header("Location: http://$host$uri/$extra");
    exit();
}

?>