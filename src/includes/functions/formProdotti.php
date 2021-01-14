<?php
    require_once __DIR__ . DIRECTORY_SEPARATOR . '../resources.php';
    use DB\DbAccess;
    if(isset($_GET['submit'])){
        $categoria = $_GET['categorie'];
        $marca = $_GET['marche'];
        $disponinile = isset($_GET['disoonibile']) ? $_GET['disponibile'] : "";
        $offerta = isset($_GET['offerta']) ? $_GET['offerta'] : "";
        $prezzoMin = $_GET['prezzoMin'];
        $prezzoMax = $_GET['prezzoMax'];
        $ordine = $_GET['ordinamento'];
        
        $dbAccess = new DBAccess();
        $connection = $dbAccess->openDbConnection();
        $query = "SELECT codArticolo FROM prodotto WHERE tipo = ".$categoria." AND
            marca = ".$marca." AND prezzo >".$prezzoMin." AND prezzo < ".$prezzoMax;
        if($disponibile == "disponibile" && $offerta == "offerta") $query .= " AND sconto > 0 AND quantita > 0";
        else if($disponibile == "disponibile") $query .= " AND quantita > 0";
        else if($offerta == "offerta") $query .= " AND sconto > 0 ";
        if($ordine == "Alfabetico [A-Z]") $query .= " ORDER BY descrizione";
        else if($ordine == "Prezzo crescente") $query .= " ORDER BY prezzo ASC";
        else if($ordine == "Prezzo decrescente") $query .= " ORDER BY prezzo DESC";
        $queryResult = mysqli_query($connection, $query);
        $prodotti = array();
        while($singoloProdotto = mysqli_fetch_row($queryResult)){
            array_push($prodotti,$singoloProdotto[0]);
        }
        $dbAccess->closeDbConnection();
    }
?>