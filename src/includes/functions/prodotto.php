<?php
namespace PRODOTTO;
require_once __DIR__ . DIRECTORY_SEPARATOR . '../resources.php';
use DB\DbAccess;
use function UTILITIES\isValidID;

// Ritorna un array associativo con i campi presenti in un prodotto, null se non c'è alcun prodotto
function getInfoFromProdotto($cod_articolo){
    if(isValidID($cod_articolo)){
        $dbAccess = new DBAccess();
        $connection = $dbAccess->openDbConnection();
        $query = "SELECT descrizione, scala, amministrazione, prezzo, sconto, marca, tipo, quantita 
                  FROM prodotto WHERE CodArticolo = ?";
        $stmt = mysqli_prepare($connection, $query);
        $stmt->bind_param("i", $articolo);
        $stmt->execute();
        $stmt->bind_result($descrizione, $scala, $amministrazione, $prezzo, $sconto, $marca, $tipo, $quantita);
        $stmt->fetch();
        //controlli
        $infoProdotto = array("Descrizione"=>$descrizione, "Scala"=>$scala, "Amm"=>$amministrazione, "Prezzo"=>$prezzo,
                        "Sconto"=>$sconto, "Marca"=>$marca, "Tipo"=>$tipo, "Qta"=>$quantita);            
        $stmt->close();
        $dbAccess->closeDbConnection();
        return $infoProdotto;
    }else{
        return false;
    }
}

function getMarche(){
    $dbAccess = new DBAccess();
    $connection = $dbAccess->openDbConnection();
    $query = "SELECT nome from marche";
    $queryResult = mysqli_query($connection, $query);
    $dbAccess->closeDbConnection();
    $marche = array();
    while($singolaMarca = mysqli_fetch_row($queryResult)){
        array_push($marche,$singolaMarca[0]);
    };
    return $marche;
}

function queryProdotti($categoria, $marca, $disponibile, $offerta, $prezzoMin, $prezzoMax, $ordine){
    $dbAccess = new DBAccess();
    $connection = $dbAccess->openDbConnection();
    $query = "SELECT codArticolo FROM prodotto WHERE 1";
    $and = "";
    if($categoria != "Nessuna selezione"){
        $query = str_replace("1","",$query);
        $query .= "tipo = \"$categoria\"";
        $and = " AND ";
    }
    if($marca != "Nessuna selezione"){
        $query = str_replace("1","",$query);
        $query .= $and."marca = \"$marca\"";
        $and = " AND ";
    }
    if($prezzoMin !=""){
        $query = str_replace("1","",$query);
        $query .= $and."prezzo >= \"$prezzoMin\"";
        $and = " AND ";
    }
    if($prezzoMax !=""){
        $query = str_replace("1","",$query);
        $query .= $and."prezzo <= \"$prezzoMax\"";
        $and = " AND ";
    }
    if($disponibile == "disponibile" && $offerta == "offerta") $query .= " AND sconto > 0 AND quantita > 0";
    else if($disponibile == "disponibile") $query .= " AND quantita > 0";
    else if($offerta == "offerta") $query .= " AND sconto > 0";
    if($ordine != "Nessuna selezione"){
        if($ordine == "Alfabetico [A-Z]") $query .= " ORDER BY descrizione";
        else if($ordine == "Prezzo crescente") $query .= " ORDER BY prezzo ASC";
        else if($ordine == "Prezzo decrescente") $query .= " ORDER BY prezzo DESC";
    }
    $queryResult = mysqli_query($connection, $query);
    $prodotti = array();
    while($singoloProdotto = mysqli_fetch_row($queryResult)){
        array_push($prodotti,$singoloProdotto[0]);
    }  
    $dbAccess->closeDbConnection();
    return $prodotti;
}
?>
