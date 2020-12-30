<?php
namespace CARRELLO;
//require_once "../resources.php";
use DB\DbAccess;
use function UTILITIES\isValidCarrello;

// Ritorna l'ID della sessione associata ad un carrello, null se non esiste
function getSessionFromCarrello($cart_id){
    if(isValidCarrello($cart_id)){
        $dbAccess = new DBAccess();
        $connection = $dbAccess->openDbConnection();
        $query = "SELECT sessionID FROM carrello WHERE cartID = \"$cart_id\"";
        $queryResult = mysqli_query($connection, $query);
        $dbAccess->closeDbConnection();
        return $queryResult;
    }else{
        return false;
    }
}

// Ritorna un array associativo di prodotti presenti in un carrello, null se non c'è alcun prodotto
function getProdottiFromCarrello($cart_id){
    if(isValidCarrello($cart_id)){
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

?>