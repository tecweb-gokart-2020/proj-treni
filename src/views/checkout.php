<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../includes/resources.php";
use function PRODOTTO\stampaProdotti;
use function CARRELLO\checkout;

session_start();
if(!isset($_SESSION["cartID"])) {
    header("Location: carrello.php");
    exit();
}

if(!isset($_SESSION["username"])) {
    header("refresh=5;url=home.php");
    include "template/errorHeader.php";
    echo '<main id="error">Errore: bisogna avere un account per effettuare un ordine.<br/>
Verrai reindirizzato alla home in 10 secondi. Se ciò non dovesse succedere clicca <a href="home.php">Qui</a></main>';
}

$checkout = &$_POST["checkout"];
$back = &$_POST["back"];
if($back) {
    header("Location: carrello.php");
    exit();
}
if($checkout) {
    $address = array(
        "nome" => $_POST["nome"];
        "cognome" => $_POST["cognome"];
        "via" => $_POST["via"];
        "civico" => $_POST["civico"];
        "citta" => $_POST["citta"];
        "provincia" => $_POST["provincia"];
        "cap" => $_POST["cap"];
        "stato" => $_POST["stato"];
        "telefono" => $_POST["telefono"];
    );
    $result = checkout($_SESSION["cartID"], $address);
    if($result) {
        header("refresh:10;url=home.php");
        echo '<main id="checkoutConfirm"><h1>Acquisto effettuato<h1>';
        exit();
    }
}

$pagedescription = "Contenuto del carrello";
$pagetitle = "carrello";
include "template/header.php";

$current_page = "carrello >> checkout";
include "template/breadcrumb.php";

echo '<main id="content">' . PHP_EOL;
$prodotti = getProdottiFromCarrello($_SESSION["cartID"]);
if($prodotti) {
    echo "<h2>Riepilogo carrello:</h2>" . PHP_EOL;
    echo "<ul id=\"cart\">" . PHP_EOL;
    foreach($prodotti as $prodotto){
	    stampaProdotti(array($prodotto["IDArticolo"]));
    }
    echo "</ul>" . PHP_EOL;
}
echo '<form><fieldset><legend>Indirizzo di spedizione</legend>
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
<button type="submit" name="checkout" id="checkout">Procedi all\'acquisto</button>
<button type="submit" name="back" id="back">Torna al carrello</button>
</form>'
    echo '</main>' . PHP_EOL;
?>
