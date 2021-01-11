<?php
namespace CARRELLO;
require_once __DIR__ . DIRECTORY_SEPARATOR . '../resources.php';
use DB\DbAccess;
use function UTILITIES\isValidID;

// Ritorna l'ID della sessione associata ad un carrello, null se non esiste
function getSessionFromCarrello($cart_id){
    if(isValidID($cart_id)){
        $dbAccess = new DBAccess();
        $connection = $dbAccess->openDbConnection();
        $query = "SELECT sessionID FROM carrello WHERE cartID = \"$cart_id\"";
        $queryResult = mysqli_query($connection, $query);
        $dbAccess->closeDbConnection();
        $session_id = mysqli_fetch_row($queryResult);
        return $session_id;
    }else{
        return false;
    }
}

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
                    "IDArticolo", $riga["codArticolo"],
                    "Qta", $riga["quantita"]
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

// Inserisce un nuovo carrello e ritorna il suo ID, false in caso di fallimento
function getNewCarrello(){
    $dbAccess = new DBAccess();
    $connection = $dbAccess->openDbConnection();
    $query = "SELECT cartID FROM carrello ORDER BY cartID DESC LIMIT 1";
    $queryResult = mysqli_query($connection, $query);
    $dbAccess->closeDbConnection();
    $cart_id = mysqli_fetch_row($queryResult)[0] + 1;
    $queryInsert = "INSERT INTO carrello(cartID) VALUES (\"$cart_id\")";
    if(mysqli_query($connection, $queryInsert)){
        return $cart_id;
    }else{
        return false;
    }
}

?>
