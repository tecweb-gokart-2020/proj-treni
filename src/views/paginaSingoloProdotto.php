<?php
    require_once __DIR__ . DIRECTORY_SEPARATOR . '../../includes/resources.php';

    use function PRODOTTO\getInfoFromProdotto;
    if(isset($_GET['codArticolo'])){
        $prodottoAttuale = $_GET['codArticolo'];
    }
    $info=getInfoFromProdotto($prodottoAttuale);
    $pagetitle = $info['marca']." ".$info['codArticolo']." - Trenogheno";
    $pagedescription = "Pagina".$info['marca']." ".$listaProdotti[$index]."di trenogheno.it";
    $area_personale_link = "href=\"info.php\"";
    $notizie_link = "href=\"notizie.php\"";
    $home_link = "href=\"../index.php\"";
    $servizi_link = "href=\"servizi.php\"";
    $contatti_link = "href=\"contatti.php\"";
    include __DIR__ . DIRECTORY_SEPARATOR . "header.php";
    
    echo '<div id="paginaSingoloProdotto">
    <h2>'.$info['marca'].' '.$prodottoAttuale.'</h2>
    <img href="'.$info['url'].'" alt=""/>
    <ul>
    <li>Categoria: '.$info['tipo'].'</li>
    <li><p>'.$info['descrizione'].'</p></li>';
    if($info['sconto']!=""){echo '<li>Si applica uno sconto del '.$info['sconto'].'%</li>';}
    echo '<li>Prezzo: '; if($info['sconto']!=""){echo '<del>';} echo $info['prezzo'].' €'; if($info['sconto']!=""){echo '</del>';} echo '</li>';
    if($info['sconto']!=""){echo '<li>'; echo $aux=$info['prezzo']-$info['sconto']/100*$info['prezzo'].' €</li>
    </ul>';}
    echo '<ul id="formAcquisto">
    <li>Prezzo: '.$aux.'</li>
    <li>Disponibili all\'acquisto: '.$info['quantita'].'</li>
    <form action="" method="post">
        <label for="quantitaOrdine">Quantità:</label>
        <input type="number" name="quantitaOrdine" max="'.$info['quantita'].'" min="1" value="1"/>
        <input type="submit" value="Aggiungi al carrello"/>
    </form>
    </ul></div>';

    include __DIR__ . DIRECTORY_SEPARATOR . "footer.php";

?>