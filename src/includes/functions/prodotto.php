<?php
namespace PRODOTTO;
require_once __DIR__ . DIRECTORY_SEPARATOR . '../resources.php';
use DB\DbAccess;
use Exception;
use function UTILITIES\isValidID;

// Ritorna un array associativo con i campi presenti in un prodotto, null se non c'è alcun prodotto
function getInfoFromProdotto($cod_articolo){
    if(isValidID($cod_articolo)){
        $dbAccess = new DBAccess();
        $connection = $dbAccess->openDbConnection();
        $query = "SELECT codArticolo, descrizione, scala, amministrazione, prezzo, sconto, marca, tipo, quantita 
                  FROM prodotto WHERE CodArticolo = \"$cod_articolo\"";
        //$stmt = mysqli_prepare($connection, $query);
        //$stmt->bind_param("i", $articolo);
        //$stmt->execute();
        //$stmt->bind_result($descrizione, $scala, $amministrazione, $prezzo, $sconto, $marca, $tipo, $quantita);
        //$stmt->fetch();
        //controlli
        //$infoProdotto = array("Descrizione"=>$descrizione, "Scala"=>$scala, "Amm"=>$amministrazione, "Prezzo"=>$prezzo,
                    //  "Sconto"=>$sconto, "Marca"=>$marca, "Tipo"=>$tipo, "Qta"=>$quantita);            
        //$stmt->close();
        $queryResult = mysqli_query($connection, $query);
        $infoProdotto = mysqli_fetch_assoc($queryResult);
        $dbAccess->closeDbConnection();
        return $infoProdotto;
    }else{
        return false;
    }
}

function stampaProdotti($listaProdotti){
    for($i=0; $i<count($listaProdotti); $i++){
        $info=getInfoFromProdotto($listaProdotti[$i]);
        echo '<li><a href="paginaSingoloProdotto.php?codArticolo='.$listaProdotti[$i].'"><h2>'.$info['marca'].' '.$listaProdotti[$i].'</h2><img href="img/'.$listaProdotti[$i].'" alt=""/>
        <ul>
        <li>'.$info['tipo'].'</li>
        <li>Disponibili all\'acquisto: '.$info['quantita'].'</li>';
        if($info['sconto']!=""){
            echo '<li>Si applica uno sconto del '.$info['sconto'].'%</li>';
        }
        echo '<li>';
        if($info['sconto']!=""){
            echo '<del>';
        }
        echo $info['prezzo'];
        if($info['sconto']!=""){
            echo '</del>';
        }
        echo '</li>';
        if($info['sconto']!=""){
            echo '<li>';
            echo $aux=$info['prezzo']-$info['sconto']/100*$info['prezzo'];
            echo '</li>';
        } 
        echo '</ul></a></li>';
    }
}

function getMarche(){
    $dbAccess = new DBAccess();
    $connection = $dbAccess->openDbConnection();
    $query = "SELECT nome from marca";
    $queryResult = mysqli_query($connection, $query);
    $dbAccess->closeDbConnection();
    $marche = array();
    while($singolaMarca = mysqli_fetch_row($queryResult)){
        array_push($marche,$singolaMarca[0]);
    };
    return $marche;
}

function queryProdotti($categoria, $marca ="Nessuna selezione", $disponibile ="", $offerta ="", $prezzoMin ="", $prezzoMax ="", $ordine ="Nessuna selezione"){
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
        if($and == ""){
            $query = str_replace("1","",$query);
        }
        $query .= $and."marca = \"$marca\"";
        $and = " AND ";
    }
    if($prezzoMin !=""){
        if($and == ""){
            $query = str_replace("1","",$query);
        }
        $query .= $and."prezzo >= ".$prezzoMin;
        $and = " AND ";
    }
    if($prezzoMax !=""){
        if($and == ""){
            $query = str_replace("1","",$query);
        }
        $query .= $and."prezzo <= ".$prezzoMax;
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

function searchProdotti($stringa){
    $dbAccess = new DBAccess();
    $connection = $dbAccess->openDbConnection();
    $stringhe = explode(" ",$stringa);
    $query = "SELECT codArticolo FROM prodotto WHERE";
    for($i=0;$i<count($stringhe);$i++){
        $query .= " (codArticolo LIKE '%".$stringhe[$i]."%' OR descrizione LIKE '%".$stringhe[$i]."%' OR 
        marca LIKE '%".$stringhe[$i]."%' OR tipo LIKE '%".$stringhe[$i]."%')";
        if($i!=count($stringhe)-1){
            $query .= " AND ";
        }
    }
    $queryResult = mysqli_query($connection, $query);
    $dbAccess->closeDbConnection();
    $prodotti = array();
    while($singoloProdotto = mysqli_fetch_row($queryResult)){
        array_push($prodotti,$singoloProdotto[0]);
    };
    return $prodotti;
}

/* quantià del prodotto $prodotto è >= a $quantità ?? scopriamolo. */
function thereAreEnoughOf($prodotto, $quantita){
    $info = getInfoFromProdotto($prodotto);
    return $info['quantita'] >= $quantita;
}

/* Dato un prodotto (con le info che possono variare da ordine a
 * ordine : quantità e prezzo), l'id dell'ordine e della spedizione lo
 * inserisce tra i prodotti ordinati, eliminandone una quantità
 * equivalente a quella in magazzino */
function ordina($prodotto, $quantita, $prezzo, $ordine, $spedizione) {
    if(isValidID($prodotto) and 
       isValidID($ordine) and 
       isValidID($spedizione)) { 
       if(thereAreEnoughOf($prodotto, $quantita)) {
		// Inserisce tra i prodotti ordinati
        	$dbAccess = new DBAccess();
        	$connection = $dbAccess->openDbConnection();
        	$query = "INSERT INTO prodotto_ordinato(codArticolo, quantita, prezzo_netto, orderID, shippingID) VALUES 
			($prodotto, $quantita, $prezzo, $ordine, $spedzione)";
		var_dump($query);
        	$queryResult = mysqli_query($connection, $query);
        	$res1 = mysqli_affected_rows($connection);
        
        	// toglie dai prodotti disponibili
        	$query = "UPDATE prodotto SET quantita = quantita - ". $quantita . " WHERE codArticolo = " . $prodotto;
       		$queryResult = mysqli_query($connection, $query);
       	 	$res2 = mysqli_affected_rows($connection);
       	 	$dbAccess->closeDbConnection();
        	return $res1 * $res2;
       } else {
       		throw new Exception("Quantità non disponibile");
       }
    }
    return false;
}
?>
