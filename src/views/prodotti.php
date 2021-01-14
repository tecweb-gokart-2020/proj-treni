<!--<!DOCTYPE html>
<html lang="it">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Trenogheno - Prodotti</title>
    <meta name="description" content="Pagina Prodotti di trenogheno.it" />
    <meta name="keywords" content="trenogheno, trenini, modellismo, prodotti, locomotive, carri" />
    <meta name="title" content="Prodotti" />
    <meta name="author" content="Gruppo progetto TecWeb" />
    <meta name="language" content="italian it" />

    <link rel="stylesheet" type="text/css" href="styleGenerale.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="styleMobile.css" media="handheld, screen and (max-device-width:640px), only screen and (max-width:640px)" />
    <link rel="stylesheet" type="text/css" href="stylePrint.css" media="print" />
</head>

<body>-->
    <?php
        require_once __DIR__ . DIRECTORY_SEPARATOR . '../includes/resources.php';
        $pagetitle = "Trenogheno - Prodotti";
        $pagedescription = "Pagina Prodotti di trenogheno.it";
        $area_personale_link = "href=\"info.php\"";
        $notizie_link = "href=\"notizie.php\"";
        $home_link = "href=\"../index.php\"";
        $servizi_link = "href=\"servizi.php\"";
        $contatti_link = "href=\"contatti.php\"";
        use function PRODOTTO\queryProdotti;
        include __DIR__ . DIRECTORY_SEPARATOR . "template/header.php";
    
    echo('<div id="percorso">
        <p>Ti trovi in: <a id="linkHome"'.$home_link.' xml:lang="en">Home</a> >> Prodotti</p>
    </div>
    <div id="categorie">
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

                    use function PRODOTTO\getMarche;
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
            <input name="prezzoMin" id="filtroPrezzoMin" type="number" value="prezzoMin" min="0" step="5" />
            <label for="filtroPrezzoMax">Prezzo massimo</label>
            <input name="prezzoMax" id="filtroPrezzoMax" type="number" value="prezzoMax" min="0" step="5" />
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
            $prezzoMin = $_GET['prezzoMin'];
            $prezzoMax = $_GET['prezzoMax'];
            $ordine = $_GET['ordinamento'];
            
            if($prezzoMax < $prezzoMin) {echo "Il prezzo massimo è stato impostato al prezzo minimo"; 
                $prezzoMax=$prezzoMin;
            }
            $listaProdotti = queryProdotti($categoria, $marca, $disponibile, $offerta, $prezzoMin, $prezzoMax, $ordine);
        }
    echo ('</div>
    <div id="contenutoPagina">
    </div>');
    include __DIR__ . DIRECTORY_SEPARATOR . "template/footer.php";
    ?>
<!--</body>

</html>-->