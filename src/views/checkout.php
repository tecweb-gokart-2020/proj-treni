<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../includes/resources.php";
use function PRODOTTO\stampaProdotti;
use function CARRELLO\checkout;
use function INDIRIZZO\getAddress;
use function CARRELLO\getProdottiFromCarrello;

session_start();
$_SESSION["cartID"] = '2';
$_SESSION["username"] = 'user';
if(!isset($_SESSION["cartID"])) {
    header("Location: carrello.php");
    exit();
}

if(!isset($_SESSION["username"])) {
    header("refresh=5;Location: home.php");
    $pagetitle = "Trenogheno - Errore";
    $pagedescription = "Trenogheno - Errore";
    include "template/header.php";
    echo '<main id="error">Errore: bisogna avere un account per effettuare un ordine.<br/>
Verrai reindirizzato alla home in 5 secondi. Se ciò non dovesse succedere clicca <a href="home.php">Qui</a></main>';
    include "template/footer.php";
}

$checkout = true; //&$_POST["checkout"];
$back = &$_POST["back"];

$_POST["nome"] = "Luca";
$_POST["cognome"] = "Zaninotto";
$_POST["via"] = "bosco dell'arneret";
$_POST["civico"] = "11";
$_POST["citta"] = "Fiume Veneto";
$_POST["provincia"] = "Pordenone";
$_POST["cap"] = "33080";
$_POST["stato"] = "Italia";
$_POST["telefono"] = "3479054568";

if($back) {
    header("Location: carrello.php");
    exit();
}
if($checkout) {
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
    var_dump($addressID);
    try {
        $result = checkout($_SESSION["cartID"], $addressID);
    } catch (Exception $e) {
        $pagedescription = "Error: Trenogheno - carrello";
        $pagetitle = "errore checkout";
        include "template/header.php";
	
        $current_page = "carrello >> checkout >> errore";
        include "template/breadcrumb.php";
        echo '<div id="errore">Qualcosa è andato storto durante l\'ordine del tuo acquisto: '. $e->getMessage() .' </div>';
        include 'template/footer.php';
        exit();
    }
    if($result) {
        $pagetitle = 'Trenogheno - conferma acquisto';
        $pagedescription = 'Conferma acquisto avvenuto su trenogheno.it';
        include 'template/header.php';
        echo '<main id="checkoutConfirm"><h1>Acquisto effettuato<h1></main>';
        include 'template/footer.php';
        exit();
    } else {
        echo "debug: errore";
    }
}

$pagedescription = "Contenuto del carrello";
$pagetitle = "carrello";
include "template/header.php";

$current_page = "carrello >> checkout";
include "template/breadcrumb.php";

echo '<main id="content">' . PHP_EOL;
echo '<form method="post"><fieldset><legend>Indirizzo di spedizione</legend>
				<label>Nome *
					<input type="text" name="nome" id="nome" maxlength="50" required/>
				</label>

				<label>Cognome *
					<input type="text" name="cognome" id="cognome" maxlength="50" required/>
				</label>

				<label>Via *
					<input type="text" name="via" id="via" maxlength="50" required/>
				</label>
				
				<label>Numero civico *
					<input type="text" name="civico" id="civico" maxlength="50" required/>
				</label>

				<label>Città *
					<input type="text" name="citta" id="citta" maxlength="50" required/>
				</label>
				
				<label>Provincia *
					<input type="text" name="provincia" id="provincia" maxlength="50" required/>
				</label>
				
				<label> <abbr title="Codice Avviamento Postale">CAP</abbr> *
					<input type="text" name="cap" id="cap" maxlength="5" required/>
				</label>

				<label>Stato *
					<input type="text" name="stato" id="stato" maxlength="50" value="Italia" required/>
				</label>

				<label>Telefono
					<input type="text" name="telefono" id="telefono" maxlength="20" />
				</label>
</fieldset>
<button type="submit" name="checkout" id="checkout" value="checkout">Procedi all\'acquisto</button>
<button type="submit" name="back" id="back" value="back">Torna al carrello</button>
</form>';
$prodotti = getProdottiFromCarrello($_SESSION["cartID"]);
if($prodotti) {
    echo "<h2>Riepilogo carrello:</h2>" . PHP_EOL;
    echo "<ul id=\"cart\">" . PHP_EOL;
    foreach($prodotti as $prodotto){
	    stampaProdotti(array($prodotto["IDArticolo"]));
    }
    echo "</ul>" . PHP_EOL;
}
echo '</main>' . PHP_EOL;

include __DIR__ . DIRECTORY_SEPARATOR . "template/footer.php";
?>
