<?php
    require_once __DIR__ . DIRECTORY_SEPARATOR . '../resources.php';
    use DB\DbAccess;
    if(isset($_GET['submit'])){
        $categoria = $_GET['categorie'];
        $marca = $_GET['marche'];
        $disponibile = isset($_GET['disponibile']) ? $_GET['disponibile'] : "";
        $offerta = isset($_GET['offerta']) ? $_GET['offerta'] : "";
        $prezzoMin = $_GET['prezzoMin'];
        $prezzoMax = $_GET['prezzoMax'];
        $ordine = $_GET['ordinamento'];
        
        $dbAccess = new DBAccess();
        $connection = $dbAccess->openDbConnection();
        //WHERE AND marca = ".$marca." AND prezzo > ".$prezzoMin." AND prezzo < ".$prezzoMax;
        $query = "SELECT codArticolo FROM prodotto WHERE 1";
        $and = "";
        if($categoria != "Nessuna selezione"){
            $query = str_replace("1","",$query);
            $query .= "tipo = ".$categoria;
            $and = " AND ";
        }
        if($marca != "Nessuna selezione"){
            $query = str_replace("1","",$query);
            $query .= $and."marca = ".$marca;
            $and = " AND ";
        }
        if($prezzoMin !=""){
            $query = str_replace("1","",$query);
            $query .= $and."prezzo > ".$prezzoMin;
            $and = " AND ";
        }
        if($prezzoMax !=""){
            $query = str_replace("1","",$query);
            $query .= $and."prezzo < ".$prezzoMax;
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
    }
?>