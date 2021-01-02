<?php
namespace PRODOTTO;
//require_once "../resources.php";
use DB\DbAccess;
use function UTILITIES\isValidID;

// Ritorna un array associativo con i campi presenti in un prodotto, null se non c'è alcun prodotto
function getInfoFromProdotto($cod_articolo){
    if(isValidID($cod_articolo)){
        $dbAccess = new DBAccess();
        $connection = $dbAccess->openDbConnection();
        $query = "SELECT descrizione, scala, amministrazione, prezzo, sconto, marca, tipo, quantita 
                  FROM prodotto WHERE CodArticolo = \"$cod_articolo\"";
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

?>