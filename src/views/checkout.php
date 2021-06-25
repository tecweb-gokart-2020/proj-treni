<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . "../includes/resources.php";
use Exception;
use function PRODOTTO\stampaProdotti;
use function CARRELLO\checkout;
use function INDIRIZZO\getAddress;
use function CARRELLO\getProdottiFromCarrello;
use function CARRELLO\setQuantityInCart;
use function CARRELLO\removeFromCart;
use function PRODOTTO\getInfoFromProdotto;

session_start();

function stampaProdotto($prodotto)
{
    $info=getInfoFromProdotto($prodotto["codArticolo"]);
    echo '<li><a href="paginaSingoloProdotto.php?codArticolo=' . $prodotto["codArticolo"] .
                                                               '"><h2>'.$info['marca'].' '.
                                                               $prodotto["codArticolo"].
                                                               '</h2></a><img src="imgs/'
                                                               .$prodotto["codArticolo"].
                                                               '" alt=""/><ul><li>'.
                                                               $info['tipo'].'</li>';
    echo '<li>';
    echo 'quantità: ' . $prodotto["quantita"];
    echo '</li>';
    echo '<li>';
    echo 'disponibili: ' . $info["quantita"];
    echo '</li>';
    if ($info['sconto']!="") {
        echo '<li>Si applica uno sconto del '.$info['sconto'].'%</li>';
    }
    echo '<li>';
    if ($info['sconto']!="") {
        echo '<del>';
    }
    echo $info['prezzo']. ' €';
    if ($info['sconto']!="") {
        echo '</del>';
    }
    echo '</li>';
    if ($info['sconto']!="") {
        echo '<li>';
        echo $aux=$info['prezzo']-$info['sconto']/100*$info['prezzo'];
        echo '</li>';
    }
    echo '</ul></li>';
}

if (!isset($_SESSION["cartID"])) {
    header("Location: carrello.php");
    exit();
}

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

$checkout = &$_POST["checkout"];
$back = &$_POST["back"];


if ($back) {
    header("Location: carrello.php");
    exit();
}
if ($checkout) {
    $address = array(
        "nome" => $_POST["nome"],
        "cognome" => $_POST["cognome"],
        "via" => $_POST["via"],
        "numero" => $_POST["civico"],
        "citta" => $_POST["citta"],
        "provincia" => $_POST["provincia"],
        "cap" => $_POST["cap"],
        "stato" => $_POST["stato"],
        "telefono" => $_POST["telefono"]
    );
    $addressID = getAddress($address, $_SESSION["username"]);
    try {
        $result = checkout($_SESSION["cartID"], $addressID);
    } catch (Exception $e) {
        $pagedescription = "Error: trenene - carrello";
        $pagetitle = "errore checkout";
        include "template/header.php";

        $current_page = "<a href=\"carrello.php\">carrello</a> >> checkout >> errore";
        include "template/breadcrumb.php";
        echo '<div id="errore">Qualcosa è andato storto durante l\'ordine del tuo acquisto: '. $e->getMessage() .' </div>';
        include 'template/footer.php';
        exit();
    }
    if ($result) {
        $pagetitle = 'trenene - conferma acquisto';
        $pagedescription = 'Conferma acquisto avvenuto su trenene.it';
        include 'template/header.php';
        echo '<main id="checkoutConfirm"><h1>Acquisto effettuato<h1></main>';
        include 'template/footer.php';
        exit();
    } else {
        echo "debug: errore";
    }
}

$js = '<script type="text/javascript" src="js/checkout.js"></script>';
$pagedescription = "Contenuto del carrello";
$pagetitle = "Carrello - Trenene";
include "template/header.php";

$current_page = '<a class="linkPercorso" href="carrello.php">carrello</a> >> checkout';
include "template/breadcrumb.php";

echo '<main id="content">' . PHP_EOL;
echo '<form method="post" id="formCheckout" novalidate aria-live="assertive"><fieldset><legend>Indirizzo di spedizione</legend>
				<label>Nome *
					<input type="text" name="nome" id="nome" maxlength="50" required autocomplete="on" aria-errormessage="errorNome" aria-invalid="false" value="'.$_POST["nome"].'"/>
				</label><br/>
                <div id="errorNome" class="errore" >Per favore inserisci un nome valido</div>
				<label>Cognome *
					<input type="text" name="cognome" id="cognome" maxlength="50" required autocomplete="on" aria-errormessage="errorCognome" aria-invalid="false" value="'.$_POST["cognome"].'"/>
				</label><br/>
                <div id="errorCognome" class="errore" >Per favore inserisci un cognome valido</div>
				<label>Via *
					<input type="text" name="via" id="via" maxlength="50" required autocomplete="on" aria-errormessage="errorVia" aria-invalid="false" value="'.$_POST["via"].'"/>
				</label><br/>
				<div id="errorVia" class="errore" >Per favore inserisci un indirizzo valido</div>
				<label>Numero civico *
					<input type="text" name="civico" id="civico" maxlength="50" required autocomplete="on" aria-errormessage="errorCivico" aria-invalid="false"/ value="'.$_POST["civico"].'">
				</label><br/>
                <div id="errorCivico" class="errore" >Per favore inserisci un numero civico valido</div>
				<label>Città *
					<input type="text" name="citta" id="citta" maxlength="50" required autocomplete="on" aria-errormessage="errorCitta" aria-invalid="false"/ value="'.$_POST["citta"].'">
				</label><br/>
				<div id="errorCitta" class="errore" >Per favore inserisci una città valida</div>
				<label>Provincia *
					<input type="text" name="provincia" id="provincia" maxlength="50" required autocomplete="on" aria-errormessage="errorProvincia" aria-invalid="false"/ value="'.$_POST["provincia"].'">
				</label><br/>
				<div id="errorProvincia" class="errore" >Per favore inserisci una provincia valida</div>
				<label> <abbr title="Codice Avviamento Postale">CAP</abbr> *
					<input type="text" name="cap" id="cap" maxlength="5" required autocomplete="on" aria-errormessage="errorCap" aria-invalid="false"/ value="'.$_POST["cap"].'">
				</label><br/>
                <div id="errorCap" class="errore" >Per favore inserisci un CAP valido</div>
				<label>Stato *
					<input type="text" name="stato" id="stato" maxlength="50" value="Italia" required autocomplete="on" aria-errormessage="errorStato" aria-invalid="false"/ value="'.$_POST["stato"].'"> 
				</label><br/>
                <div id="errorStato" class="errore" >Per favore inserisci uno stato valido</div>
				<label>Telefono</br><em>Solo numeri italiani</em>
					<input type="text" name="telefono" id="telefono" maxlength="20" autocomplete="on" aria-errormessage="errorTelefono" aria-invalid="false"/ value="'.$_POST["telefono"].'">
				</label><br/>
                <div id="errorTelefono" class="errore" >Il numero inserito non è valido</div>
</fieldset>
<button type="submit" name="checkout" id="checkout" value="checkout">Procedi all\'acquisto</button>
</form><a href="carrello.php">Torna al carrello</a>';
$prodotti = getProdottiFromCarrello($_SESSION["cartID"]);
if ($prodotti) {
    echo "<h2>Riepilogo carrello:</h2>" . PHP_EOL;
    echo "<ul id=\"cart\">" . PHP_EOL;
    foreach ($prodotti as $prodotto) {
        stampaProdotto($prodotto);
    }
    echo "</ul>" . PHP_EOL;
}
echo '</main>' . PHP_EOL;

include __DIR__ . DIRECTORY_SEPARATOR . "template/footer.php";

?>