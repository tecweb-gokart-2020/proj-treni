<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../includes/resources.php';
use function PRODOTTO\queryProdotti;
use function PRODOTTO\getMarche;
use function PRODOTTO\stampaProdotti;
use function PRODOTTO\searchProdotti;

$js = '<script type="text/javascript" src="js/prodotti.js"></script>';
$pagetitle = "Prodotti - trenene";
$pagedescription = "Pagina Prodotti di trenene.it";
$tag_prodotti = '<span class="current_link">';
include "template/header.php";
    
$current_page = "prodotti";
include "template/breadcrumb.php";

echo '<main id="content">' . PHP_EOL;
if(isset($_GET['categoriaSelezionata'])){
    switch($_GET['categoriaSelezionata']){
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
        default:
    	$listaProdotti=queryProdotti("");
            break;

    }
}
    
if(isset($_GET['search'])){
    $searchString = $_GET['searchQuery'];
    $listaProdotti = searchProdotti($searchString);
}

// BOTTONI CON LE CATEGORIE DI PRODOTTI
if(!isset($_GET['categorie']) and
	!isset($_GET['categoriaSelezionata']) and
	!isset($_GET['prezzoMin']) and
	!isset($_GET['prezzoMax']) and
	!isset($_GET['marche']) and
	!isset($_GET['ordinamento']) and
	!isset($_GET['searchQuery'])){
    echo('<div id="categorie">
            <form>
                <input type="submit" name="categoriaSelezionata" value="Locomotive"/>
                <input type="submit" name="categoriaSelezionata" value="Carrozze"/>
                <input type="submit" name="categoriaSelezionata" value="Carri"/>
                <input type="submit" name="categoriaSelezionata" value="Binari"/>
                <input type="submit" name="categoriaSelezionata" value="Accessori"/>
                <input type="submit" name="categoriaSelezionata" value="Tutti i prodotti"/>
            </form>
        </div>');
}
//FILTRO PRODOTTI
echo '<div id="filtroProdotti">
        <form id="formFiltro" novalidate>
            <label id="labelCategoria" for="filtroCategorie">Categoria</label>
            <select name="categorie" id="filtroCategorie">
		<option value="" disabled="disabled" selected="selected">categoria</option>';
                echo '<option value="locomotiva"'; if($_GET["categorie"]=="locomotiva" || $_GET['categoriaSelezionata']=="Locomotive"){echo ' selected="selected"';} echo '>Locomotive</option>';
                echo '<option value="carrozza"'; if($_GET["categorie"]=="carrozza" || $_GET['categoriaSelezionata']=="Carrozze"){echo ' selected="selected"';} echo '>Carrozze</option>';
                echo '<option value="carro"'; if($_GET["categorie"]=="carro" || $_GET['categoriaSelezionata']=="Carri"){echo ' selected="selected"';} echo '>Carri</option>';
                echo '<option value="accessorio"'; if($_GET["categorie"]=="accessorio" || $_GET['categoriaSelezionata']=="Accessori"){echo ' selected="selected"';} echo '>Accessori</option>';
                echo '<option value="binario"'; if($_GET["categorie"]=="binario" || $_GET['categoriaSelezionata']=="Binari"){echo ' selected="selected"';} echo '>Binari</option>';
            echo '</select>
            <label id="labelMarche" for="filtroMarche">Marca</label>
            <select name="marche" id="filtroMarche">
		<option value="" disabled="disabled" '; 
		if(!$_GET["marche"]){ echo ' selected="selected"';}
		echo '>marca</option>';
            $marche = getMarche();
            for($i = 0;$i < count($marche);$i++){
                echo'<option';
                if($_GET['marche']==$marche[$i]){echo ' selected="selected"';}
                echo'>'.$marche[$i].'</option>';
            }
echo '</select>
            <label id="labelDisponibile" for="filtroDisponibile">Disponibile</label>';
            echo '<input name="disponibile" id="filtroDisponibile" type="checkbox" value="disponibile"'; if($_GET["disponibile"]=="disponibile"){echo ' checked="checked"';} echo '/>';
            echo '<label id="labelOfferta" for="filtroInOfferta">In Offerta</label>';
            echo '<input name="offerta" id="filtroInOfferta" type="checkbox" value="offerta"'; if($_GET["offerta"]=="offerta"){echo ' checked="checked"';} echo '/>';
            echo '<label id="labelMin" for="filtroPrezzoMin">Prezzo minimo</label>';
            echo '<input name="prezzoMin" id="filtroPrezzoMin" type="number" value="';if(isset($_GET["prezzoMin"])){echo $_GET["prezzoMin"];} echo'" min="0" step="5" aria-errormessage="erroreFiltro" aria-invalid="false"/>';
            echo '<label id="labelMax" for="filtroPrezzoMax">Prezzo massimo</label>
            <input name="prezzoMax" id="filtroPrezzoMax" type="number" value="';if(isset($_GET["prezzoMax"])){echo $_GET["prezzoMax"];}echo '" min="0" step="5" aria-errormessage="erroreFiltro" aria-invalid="false"/>
            <label id="labelOrdinamento" for="filrtoOrdinamento">Ordinamento</label>
            <select name="ordinamento" id="filrtoOrdinamento">
		<option value="" disabled="disabled"'; 
	if(!$_GET['ordinamento']){echo ' selected="selected"';} 
	echo '>ordine</option>';
		echo '<option value="alfabetico"'; if($_GET["ordinamento"]=="alfabetico"){echo ' selected="selected"';} echo '>Alfabetico [A-Z]</option>';
                echo '<option value="prezzoCrescente"'; if($_GET["ordinamento"]=="prezzoCrescente"){echo ' selected="selected"';} echo '>Prezzo crescente</option>';
                echo '<option value="prezzoDecrescente"'; if($_GET["ordinamento"]=="prezzoDecrescente"){echo ' selected=selected';} echo '>Prezzo decrescente</option>';
            echo '</select>
            <input id="filtroSubmit" type="submit" name="submit" value="Applica filtri"/>
            <div class="errore" id="erroreFiltro" aria-live="assertive"></div>
        </form>';

// PRODOTTI TROVATI
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
    <div id="contenutoPagina">');
if($listaProdotti){
	echo('<ul class="cards">');
	stampaProdotti($listaProdotti);
	echo('</ul>');
} else if($_GET['submit']) echo '<h3>Nessun prodotto trovato corrispondente alla chiave di ricerca</h3>';
echo ('</div>');
echo '</main>';
include __DIR__ . DIRECTORY_SEPARATOR . "template/footer.php";
?>
