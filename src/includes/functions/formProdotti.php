<?php
    require_once __DIR__ . DIRECTORY_SEPARATOR . '../resources.php';
    use DB\DbAccess;

    $categoria = $_GET["categorie"];
    $marca = $_GET["marche"];
    $disponinile = $_GET["disoonibile"];
    $offerta = $_GET["offerta"];
    $prezzoMin = $_GET["prezzoMin"];
    $prezzoMax = $_GET["prezzoMax"];
    $ordine = $_GET["ordinamento"];
    
    
    $query = "SELECT codArticolo FROM prodotto WHERE tipo = ".$categoria." AND
         marca = ".$marca." AND prezzo >".$prezzoMin." AND prezzo < ".$prezzoMax;
    if($disponibile && $offerta) $query .= " AND sconto > 0 AND quantita > 0";
    else if($disponibile) $query .= " AND quantita > 0";
    else if($offerta) $query .= " AND sconto > 0 ";
    
?>