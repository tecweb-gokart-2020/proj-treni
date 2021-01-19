<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../includes/resources.php';
use function PRODOTTO\queryProdotti;
use function PRODOTTO\getMarche;
use function PRODOTTO\stampaProdotti;
use function PRODOTTO\searchProdotti;

$pagetitle = "Trenogheno - Prodotti";
$pagedescription = "Pagina Prodotti di trenogheno.it";
$tag_prodotti = '<span class="current_link">';
include "template/header.php";
    
$current_page = "prodotti";
include "template/breadcrumb.php";

echo '<main id="content">' . PHP_EOL;
echo('<div id="categorie">
        <form>
            <ul>
                <li><input type="submit" name="cat" value="Locomotive"/></li>
                <li><input type="submit" name="cat" value="Carrozze"/></li>
                <li><input type="submit" name="cat" value="Carri"/></li>
                <li><input type="submit" name="cat" value="Binari"/></li>
                <li><input type="submit" name="cat" value="Accessori"/></li>
            </ul>
        </form>
    </div>');

if(isset($_GET['cat'])){
    switch($_GET['cat']){
        case "Locomotive":
            $listaProdotti=queryProdotti("locomotiva");
            break;
        case "Carrozze":
            $listaProdotti=queryProdotti("carrozza");
            break;
        case "Carri":
            $listaProdotti=queryProdotti("carro");
            break;
        case "Binari":
            $listaProdotti=queryProdotti("binario");
            break;
        case "Accessori":
            $listaProdotti=queryProdotti("accessorio");
            break;
    }
}

if(isset($_GET['search'])){
    $searchString = $_GET['searchQuery'];
    $listaProdotti = searchProdotti($searchString);
}

echo '<div id="filtroProdotti">
        <form>
            <label for="filtroCategorie">Categoria</label>
            <select name="categorie" id="filtroCategorie">
                <option>Nessuna selezione</option>
				<option value="locomotiva">Locomotive</option>
                <option value="carrozza">Carrozze</option>
                <option value="carro">Carri</option>
                <option value="accessorio">Accessori</option>
                <option value="binario">Binari</option>
            </select>
            <label for="filtroMarche">Marca</label>
            <select name="marche" id="filtroMarche">
                <option>Nessuna selezione</option>';
$marche = getMarche();
for($i = 0;$i < count($marche);$i++){
    echo("<option>".$marche[$i]."</option>");
}
echo('</select>
            <label for="filtroDisponibile">Disponibile</label>
            <input name="disponibile" id="filtroDisponibile" type="checkbox" value="disponibile" />
            <label for="filtroInOfferta">In Offerta</label>
            <input name="offerta" id="filtroInOfferta" type="checkbox" value="offerta" />
            <label for="filtroPrezzoMin">Prezzo minimo</label>
            <input name="prezzoMin" id="filtroPrezzoMin" type="number" value="0" min="0" step="5" />
            <label for="filtroPrezzoMax">Prezzo massimo</label>
            <input name="prezzoMax" id="filtroPrezzoMax" type="number" value="10000" min="0" step="5" />
            <label for="filrtoOrdinamento">Ordinamento</label>
            <select name="ordinamento" id="filrtoOrdinamento">
                <option>Nessuna selezione</option>
				<option>Alfabetico [A-Z]</option>
                <option>Prezzo crescente</option>
                <option>Prezzo decrescente</option>
            </select>
            <input id="filtroSubmit" type="submit" name="submit" value="Applica filtri" />
        </form>');
if(isset($_GET['submit'])){
    $categoria = $_GET['categorie'];
    $marca = $_GET['marche'];
    $disponibile = isset($_GET['disponibile']) ? $_GET['disponibile'] : "";
    $offerta = isset($_GET['offerta']) ? $_GET['offerta'] : "";
    $prezzoMin = isset($_GET['prezzoMin']) ? $_GET['prezzoMin'] : "";
    $prezzoMax = isset($_GET['prezzoMax']) ? $_GET['prezzoMax'] : "";
    $ordine = $_GET['ordinamento'];
    if($prezzoMax != "" && $prezzoMin != ""){
        if($prezzoMax < $prezzoMin) {echo "Il prezzo massimo è stato impostato al prezzo minimo"; 
            $prezzoMax=$prezzoMin;
        }
    }
    $listaProdotti = queryProdotti($categoria, $marca, $disponibile, $offerta, $prezzoMin, $prezzoMax, $ordine);
}

echo ('</div>
    <div id="contenutoPagina">
        <ul class="cards">');                            
stampaProdotti($listaProdotti);
echo('</ul>
    </div>');
echo '</main>';
include __DIR__ . DIRECTORY_SEPARATOR . "template/footer.php";
?>
