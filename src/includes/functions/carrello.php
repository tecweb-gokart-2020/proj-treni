<?php
namespace CARRELLO;
require_once __DIR__ . DIRECTORY_SEPARATOR . '../resources.php';
use DB\DbAccess;
use function UTILITIES\isValidID;
use function ORDINE\makeNewOrdine;
use function PRODOTTO\ordina;
use function SPEDIZIONE\makeNewSpedizione;

// Ritorna un array associativo di prodotti presenti in un carrello, null se non c'è alcun prodotto
function getProdottiFromCarrello($cart_id){
    if(isValidID($cart_id)){
        $dbAccess = new DBAccess();
        $connection = $dbAccess->openDbConnection();
        $query = "SELECT codArticolo, quantita FROM contenuto_carrello WHERE cartID = \"$cart_id\"";
        $queryResult = mysqli_query($connection, $query);
        $listaProdotti = array();
        if(mysqli_num_rows($queryResult)!=0){
            while($riga = mysqli_fetch_assoc($queryResult)){
                $singoloProdotto = array(
                    "IDArticolo" => $riga["codArticolo"],
                    "Qta" => $riga["quantita"]
                );    
                array_push($listaProdotti,$singoloProdotto);
            }
        }
        $dbAccess->closeDbConnection();
        return $listaProdotti;
    }else{
        return false;
    }
}

/* Fatta al volo, peer review ben accetta */
function getAccountFromCarrello($cart_id){
    if(isValidID($cart_id)){
        $dbAccess = new DBAccess();
        $connection = $dbAccess->openDbConnection();
        $query = "SELECT username FROM utente WHERE cartID = \"$cart_id\"";
        $queryResult = mysqli_query($connection, $query);
        if(mysqli_num_rows($queryResult) === 1){
            $account = mysqli_fetch_array($query_result)[0];
        }
        else{
            $account= false;
        }
        $dbAccess->closeDbConnection();
        return $account;
    }else{
        return false;
    }
}

// Inserisce un nuovo carrello e ritorna il suo ID, false in caso di fallimento
function getNewCarrello(){
    $dbAccess = new DBAccess();
    $connection = $dbAccess->openDbConnection();
    $query = "SELECT cartID FROM carrello ORDER BY cartID DESC LIMIT 1";
    $queryResult = mysqli_query($connection, $query);
    $cart_id = mysqli_fetch_row($queryResult)[0] + 1;
    $queryInsert = "INSERT INTO carrello(cartID) VALUES (\"$cart_id\")";
    if(mysqli_query($connection, $queryInsert)){
        $dbAccess->closeDbConnection();
        return $cart_id;
    }else{
        $dbAccess->closeDbConnection();
        return false;
    }
}

/* cartID è l'id ben formato di un carrello, $address è una mappa che
 * contiene tutti i campi necessari per la definizione di un indirizzo
 * (come esempio vedere views/checkout.php linea 26). Ritorna true se
 * l'acquisto va a buon fine, -1 se l'id del carrello è invalido, 0 se
 * l'indirizzo ha qualche campo errato */
function checkout($cartID, $addressID) {
    $prodotti = getProdottiFromCarrello($cartID);
    $account = getAccountFromCarrello($cartID);
    $totale = 0;
    foreach($prodotti as $prodotto) {
        $total += getInfoProdotto($prodotto["codArticolo"])["prezzo"];
    }
    $orderID = makeNewOrdine($account, $totale);
    $ship = makenewSpedizione($orderID, $addressID, 'Processing');
    foreach($prodotti as $prodotto){
        $response = ordina($prodotto["codArticolo"],
                           $prodotto["quantita"],
                           $prodotto["prezzo"],
                           $orderID,
                           $ship);
    }
}
?>
