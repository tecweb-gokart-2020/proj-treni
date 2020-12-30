<?php
require_once "../resources.php";
use DB\DbAccess;

function getSessionCarrello($cart_id){
    $reg_expr = "/^\d+$/";
    if(preg_match($reg_expr,$cart_id)!=0){
        $dbAccess = new DBAccess();
        $dbAccess->openDbConnection();
        $query = "SELECT sessionID FROM carrello WHERE cartID = \"$cart_id\"";
        $queryResult = mysqli_query($dbAccess->connection, $query);    
        $dbAccess->closeDbConnection();
        return $queryResult;
    }else{
        error_log("Invalid cartID! Must be a number");
        return false;
    }
}

function getProdottiCarrello($cart_id){
    $reg_expr = "/^\d+$/";
    if(preg_match($reg_expr,$cart_id)!=0){
        $dbAccess = new DBAccess();
        $dbAccess->openDbConnection();
        $query = "SELECT codArticolo, quantita FROM contenuto_carrello WHERE cartID = \"$cart_id\"";
        $queryResult = mysqli_query($dbAccess->connection, $query);
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
        error_log("Invalid cartID! Must be a number");
        return false;
    }
}

?>