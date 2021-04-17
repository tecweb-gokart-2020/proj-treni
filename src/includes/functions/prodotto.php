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
        $queryResult = mysqli_query($connection, $query);
        $infoProdotto = mysqli_fetch_assoc($queryResult);
        $dbAccess->closeDbConnection();
        return $infoProdotto;
    }else{
        return false;
    }
}

function stampaProdotti($listaProdotti, $printQuantity = false, $qty=null){
    for($i=0; $i<count($listaProdotti); $i++){
        $info=getInfoFromProdotto($listaProdotti[$i]);
	echo '<li class="prodottoLista"><a href="paginaSingoloProdotto.php?codArticolo=' . $listaProdotti[$i]. '"><h2>'.$info['marca'].' '. $listaProdotti[$i]. '</h2><img src="imgs/' .$listaProdotti[$i]. '" alt=""/><ul class="propProdotto"><li>' . $info['descrizione'].'</li>';
        if($info['sconto']!=""){
            echo '<li>Prodotto scontato del '.$info['sconto'].'%</li>';
        }
        echo '<li>';
        if($info['sconto']!=""){
            echo '<del>';
        }
        echo "Prezzo: ".$info['prezzo']." €";
        if($info['sconto']!=""){
            echo '</del>';
        }
        echo '</li>';
        if($info['sconto']!=""){
            echo '<li>';
            echo "Prezzo: ".$info['prezzo']-$info['sconto']/100*$info['prezzo']." €";
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

function queryProdotti($categoria, $marca ="", $disponibile ="", $offerta ="", $prezzoMin ="", $prezzoMax ="", $ordine =""){
    $dbAccess = new DBAccess();
    $connection = $dbAccess->openDbConnection();
    $query = "SELECT codArticolo FROM prodotto WHERE 1";
    $and = "";
    if($categoria != ""){
        $query = str_replace("1","",$query);
        $query .= "tipo = \"$categoria\"";
        $and = " AND ";
    }
    if($marca != ""){
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
        if($ordine == "alfabetico") $query .= " ORDER BY descrizione";
        else if($ordine == "prezzoCrescente") $query .= " ORDER BY prezzo ASC";
        else if($ordine == "prezzoDecrescente") $query .= " ORDER BY prezzo DESC";
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
        	$query = "INSERT INTO prodotto_ordinato(codArticolo, quantita, prezzo_netto, orderID, shippingID) VALUES ".
			"(". $prodotto .", ". $quantita .", ". $prezzo .", ". $ordine .", ". $spedizione .")";
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

function ultimeNovita() {
	$db = new DBAccess();
	$connection = $db->openDbConnection();
	$query = "select codArticolo from prodotto where novita = 1 order by rand() limit 6";
	$res = mysqli_query($connection, $query);
	$to_return = array();
	while($prod = mysqli_fetch_row($res)[0]) {
		array_push($to_return, $prod);
	}
	return $to_return;
}

/* Ritorna il codice dell'articolo inserito se l'inserimento è andato a buon fine, ritorna null altrimenti */
function insertProdotto($prodotto) {
    $db = new DbAccess();
    $connection = $db->openDbConnection();
    $query = "insert into prodotto(codArticolo, quantita, descrizione, amministrazione, scala, prezzo, sconto, tipo, marca, novita) values ("
        . $prodotto['codArticolo']
        . ", " . $prodotto['quantita']
        . ", " . $prodotto['descrizione']
        . ", " . $prodotto['amministrazione']
        . ", " . $prodotto['scala']
        . ", " . $prodotto['prezzo']
        . ", " . $prodotto['sconto']
        . ", " . $prodotto['tipo']
        . ", " . $prodotto['marca']
        . ", " . 1
        . ")";
    $res = mysqli_query($connection, $query);
    return (mysqli_affected_rows($res) == 1) ? $prodotto['codArticolo'] : NULL;
}

function editProdotto($prodotto) {
    $db = new DbAccess();
    $connection = $db->openDbConnection();
    $query = "update prodotto set "
    . $prodotto['quantita'] ? ", quantita=" . $prodotto['quantita'] : ""
    . $prodotto['descrizione'] ? ", descrizione=" . $prodotto['descrizione'] : ""
    . $prodotto['amministrazione'] ? ", amministrazione=" . $prodotto['amministrazione'] : ""
    . $prodotto['scala'] ? ", scala=" . $prodotto['scala'] : ""
    . $prodotto['prezzo'] ? ", prezzo=" . $prodotto['prezzo'] : ""
    . $prodotto['sconto'] ? ", sconto=" . $prodotto['sconto'] : ""
    . $prodotto['tipo'] ? ", tipo=" . $prodotto['tipo'] : ""
    . $prodotto['marca'] ? ", marca=" . $prodotto['marca'] : ""
    . $prodotto['novita'] ? ", novita=" . $prodotto['novita'] : ""
        . " where codArticolo=\"" . $prodotto['codAticolo'] . "\")";
    $res = mysqli_query($connection, $query);
    return (mysqli_affected_rows($res) == 1) ? $prodotto['codArticolo'] : NULL;
}

/* Prodotto in questo caso è direttamente l'id del prodotto da eliminare */
function deleteProdotto($prodotto) {
    $db = new DbAccess();
    $connection = $db->openDbConnection();
    $query = "delete from prodotto where codArticolo=\"$prodotto\"";
    $res = mysqli_query($connection, $query);
    return mysqli_affected_rows($res) == 1;
}
?>
