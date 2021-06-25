<?php

namespace PRODOTTO;

require_once __DIR__ . DIRECTORY_SEPARATOR . '../resources.php';
use DB\DbAccess;
use Exception;
use function UTILITIES\isValidID;

// Ritorna un array associativo con i campi presenti in un prodotto, null se non c'è alcun prodotto
function getInfoFromProdotto($cod_articolo)
{
    if (isValidID($cod_articolo)) {
        $dbAccess = new DBAccess();
        $connection = $dbAccess->openDbConnection();
        $query = "SELECT codArticolo, descrizione, scala, amministrazione, prezzo, sconto, marca, tipo, quantita 
                  FROM prodotto WHERE CodArticolo = \"$cod_articolo\"";
        $queryResult = mysqli_query($connection, $query);
        $infoProdotto = mysqli_fetch_assoc($queryResult);
        $dbAccess->closeDbConnection();
        return $infoProdotto;
    } else {
        return false;
    }
}

function stampaProdotti($listaProdotti, $printQuantity = false, $qty=null)
{
    for ($i=0; $i<count($listaProdotti); $i++) {
        $info=getInfoFromProdotto($listaProdotti[$i]);
        echo '<li class="prodottoLista"><a class="linkListaProdotti" href="paginaSingoloProdotto.php?codArticolo=' . $listaProdotti[$i]. '"><h2 class="titoloProdottoListaProdotti">'.$info['marca'].' '. $listaProdotti[$i]. '</h2><img class="immaginiListaProdotti" src="imgs/' .$listaProdotti[$i]. '" alt=""/><ul class="propProdotto"><li>' . $info['descrizione'].'</li>';
        $inSconto = false;
        if ($info['sconto']>0) {
            $inSconto = true;
        }
        if ($inSconto) {
            echo '<li>Prodotto scontato del '.$info['sconto'].'%</li>';
        }
        echo '<li>';
        if ($inSconto) {
            echo '<del>';
        }
        echo "Prezzo: ".$info['prezzo']." €";
        if ($inSconto) {
            echo '</del>';
        }
        echo '</li>';
        if ($inSconto) {
            echo '<li>';
            echo "Prezzo: ".($info['prezzo']-$info['sconto']/100*$info['prezzo'])." €";
            echo '</li>';
        }
        echo '</ul></a></li>';
    }
}

function getMarche()
{
    $dbAccess = new DBAccess();
    $connection = $dbAccess->openDbConnection();
    $query = "SELECT nome from marca";
    $queryResult = mysqli_query($connection, $query);
    $dbAccess->closeDbConnection();
    $marche = array();
    while ($singolaMarca = mysqli_fetch_row($queryResult)) {
        array_push($marche, $singolaMarca[0]);
    };
    return $marche;
}

function queryProdotti($categoria, $marca ="", $disponibile ="", $offerta ="", $prezzoMin ="", $prezzoMax ="", $ordine ="")
{
    $dbAccess = new DBAccess();
    $connection = $dbAccess->openDbConnection();
    $query = "SELECT codArticolo FROM prodotto WHERE 1";
    $and = "";
    if ($categoria != "") {
        $query = str_replace("1", "", $query);
        $query .= "tipo = \"$categoria\"";
        $and = " AND ";
    }
    if ($marca != "") {
        if ($and == "") {
            $query = str_replace("1", "", $query);
        }
        $query .= $and."marca = \"$marca\"";
        $and = " AND ";
    }
    if ($prezzoMin !="") {
        if ($and == "") {
            $query = str_replace("1", "", $query);
        }
        $query .= $and."prezzo >= ".$prezzoMin;
        $and = " AND ";
    }
    if ($prezzoMax !="") {
        if ($and == "") {
            $query = str_replace("1", "", $query);
        }
        $query .= $and."prezzo <= ".$prezzoMax;
        $and = " AND ";
    }
    if ($disponibile == "disponibile" && $offerta == "offerta") {
        $query .= " AND sconto > 0 AND quantita > 0";
    } elseif ($disponibile == "disponibile") {
        $query .= " AND quantita > 0";
    } elseif ($offerta == "offerta") {
        $query .= " AND sconto > 0";
    }
    if ($ordine != "Nessuna selezione") {
        if ($ordine == "alfabetico") {
            $query .= " ORDER BY descrizione";
        } elseif ($ordine == "prezzoCrescente") {
            $query .= " ORDER BY prezzo ASC";
        } elseif ($ordine == "prezzoDecrescente") {
            $query .= " ORDER BY prezzo DESC";
        }
    }
    $queryResult = mysqli_query($connection, $query);
    $prodotti = array();
    while ($singoloProdotto = mysqli_fetch_row($queryResult)) {
        array_push($prodotti, $singoloProdotto[0]);
    }
    $dbAccess->closeDbConnection();
    return $prodotti;
}

function searchProdotti($stringa)
{
    $dbAccess = new DBAccess();
    $connection = $dbAccess->openDbConnection();
    $stringhe = explode(" ", $stringa);
    $query = "SELECT codArticolo FROM prodotto WHERE";
    for ($i=0;$i<count($stringhe);$i++) {
        $query .= " (codArticolo LIKE '%".$stringhe[$i]."%' OR descrizione LIKE '%".$stringhe[$i]."%' OR 
        marca LIKE '%".$stringhe[$i]."%' OR tipo LIKE '%".$stringhe[$i]."%')";
        if ($i!=count($stringhe)-1) {
            $query .= " AND ";
        }
    }
    $queryResult = mysqli_query($connection, $query);
    $dbAccess->closeDbConnection();
    $prodotti = array();
    while ($singoloProdotto = mysqli_fetch_row($queryResult)) {
        array_push($prodotti, $singoloProdotto[0]);
    };
    return $prodotti;
}

/* quantià del prodotto $prodotto è >= a $quantità ?? scopriamolo. */
function thereAreEnoughOf($prodotto, $quantita)
{
    $info = getInfoFromProdotto($prodotto);
    return $info['quantita'] >= $quantita;
}

/* Dato un prodotto (con le info che possono variare da ordine a
 * ordine : quantità e prezzo), l'id dell'ordine e della spedizione lo
 * inserisce tra i prodotti ordinati, eliminandone una quantità
 * equivalente a quella in magazzino */
function ordina($prodotto, $quantita, $prezzo, $ordine, $spedizione)
{
    if (isValidID($prodotto) and
       isValidID($ordine) and
       isValidID($spedizione)) {
        if (thereAreEnoughOf($prodotto, $quantita)) {
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

function ultimeNovita()
{
    $db = new DBAccess();
    $connection = $db->openDbConnection();
    $query = "select codArticolo from prodotto where novita = 1 order by rand() limit 6";
    $res = mysqli_query($connection, $query);
    $to_return = array();
    while ($prod = mysqli_fetch_row($res)[0]) {
        array_push($to_return, $prod);
    }
    return $to_return;
}

/* Ritorna il codice dell'articolo inserito se l'inserimento è andato a buon fine, ritorna null altrimenti */
function insertProdotto($prodotto, $image)
{
    $db = new DbAccess();
    $connection = $db->openDbConnection();
    mysqli_begin_transaction($connection);
    if ($prodotto['sconto'] == "") {
        $prodotto['sconto'] = "NULL";
    }
    mysqli_query($connection, "insert into marca(nome) values (\"" . strtolower($prodotto['marca']) . "\")");
    $query = "insert into prodotto(codArticolo, quantita, descrizione, amministrazione, scala, prezzo, sconto, tipo, marca, novita) values ("
           . $prodotto['codArticolo']
           . ", " . $prodotto['quantita']
           . ", \"" . $prodotto['descrizione'] .'"'
           . ", \"" . $prodotto['amministrazione'] . '"'
           . ", \"" . $prodotto['scala'] . '"'
           . ", \"" . $prodotto['prezzo'] . '"'
           . ", \"" . $prodotto['sconto'] . '"'
           . ", \"" . $prodotto['tipo'] . '"'
           . ", \"" . $prodotto['marca'] . '"'
           . ", " . 1
           . ")";
    $res = mysqli_query($connection, $query);
    if ($res == false) {
        mysqli_rollback($connection);
        return false;
    }
    $target_dir = "./imgs/";
    $target_file = $target_dir . $prodotto["codArticolo"];
    $check = getimagesize($image["tmp_name"]);
    if ($check !== false) {
        $moveOk = move_uploaded_file($image["tmp_name"], $target_file);
        if ($moveOk) {
            mysqli_commit($connection);
            return true;
        }
    }
    mysqli_rollback($connection);
    return false;
}

function specifyEditQuery($name, $value)
{
    if ($value == "") {
        return 'update prodotto set ' . $name . '=NULL';
    }
    return 'update prodotto set ' . $name . '="' . $value . '"';
}

function editProdotto($prodotto)
{
    $db = new DbAccess();
    $connection = $db->openDbConnection();
    $result = true;
    mysqli_begin_transaction($connection);
    foreach ($prodotto as $key => $property) {
        if ($key != "codArticolo") {
            $query = specifyEditQuery($key, $property) . ' where codArticolo="' . $prodotto['codArticolo'] . '"';
            $res = mysqli_query($connection, $query);
            $result = ($result and $res);
        }
    }
    if ($result) {
        mysqli_commit($connection);
    } else {
        mysqli_rollback($connection);
    }
    mysqli_close($connection);
    $db->closeDbConnection();
    return $result;
}

/* Prodotto in questo caso è direttamente l'id del prodotto da eliminare */
function deleteProdotto($prodotto)
{
    $db = new DbAccess();
    $connection = $db->openDbConnection();
    $query = "delete from contenuto_carrello where codArticolo=$prodotto";
    mysqli_query($connection, $query);
    $query = "delete from prodotto where codArticolo=$prodotto";
    return mysqli_query($connection, $query);
}
