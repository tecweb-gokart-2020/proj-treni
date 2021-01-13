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
        include __DIR__ . DIRECTORY_SEPARATOR . "template/header.php";
    ?>
    <div id="percorso">
        <p>Ti trovi in: <a id="linkHome" <?=$home_link;?> xml:lang="en">Home</a> >> Prodotti</p>
    </div>
    <div id="categorie">
        <ul>
            <li><a href="#contenutoPagina" onclick="filtroLocomotive();">Locomotive</a></li>
            <li><a href="#contenutoPagina" onclick="filtroCarrozze();">Carrozze</a></li>
            <li><a href="#contenutoPagina" onclick="filtroCarri();">Carri</a></li>
            <li><a href="#contenutoPagina" onclick="filtroBinari();">Binari</a></li>
            <li><a href="#contenutoPagina" onclick="filtroAccessori();">Accessori</a></li>
        </ul>
    </div>
    <div id="filtroProdotti">
        <form method="get" action="..includes/functions/formProdotti.php">
            <label for="filtroCategorie">Categoria</label>
            <select name="categorie" id="filtroCategorie">
                <option>Nessuna selezione</option>
				<option>Locomotive</option>
                <option>Carrozze</option>
                <option>Carri</option>
                <option>Accessori</option>
                <option>Binari</option>
            </select>
            <label for="filtroMarche">Marca</label>
            <select name="marche" id="filtroMarche">
                <option>Nessuna selezione</option>
                <?php
                    use function PRODOTTO\getMarche;
                    $marche = getMarche();
                    for($i = 0;$i < count($marche);$i++){
                        echo("<option>".$marche[$i]."</option>");
                    }
                ?>
            </select>
            <label for="filtroDisponibile">Disponibile</label>
            <input name="disponibile" id="filtroDisponibile" type="checkbox" value="disponibile" />
            <label for="filtroInOfferta">In Offerta</label>
            <input name="offerta" id="filtroInOfferta" type="checkbox" value="offerta" />
            <label for="filtroPrezzoMin">Prezzo minimo</label>
            <input name="prezzoMin" id="filtroPrezzoMin" type="number" value="prezzoMin" min="0" step="5" />
            <label for="filtroPrezzoMax">Prezzo massimo</label>
            <input name="prezzoMax" id="filtroPrezzoMax" type="number" value="prezzoMax" min="0" step="5" />
            <label for="filrtoOrdinamento">Ordinamento</label>
            <select name="ordinamento" id="filrtoOrdinamento"><!--DA CAPIRE MEGLIO CON PHP-->
                <option>Nessuna selezione</option>
				<option>Alfabetico [A-Z]</option>
                <option>Prezzo crescente</option>
                <option>Prezzo decrescente</option>
            </select>
            <input id="filtroSubmit" type="submit" value="Applica filtri" />
        </form>
    </div>
    <div id="contenutoPagina">
        <!--PRODOTTI DA METTERE CON PHP-->
    </div>
    <?php
    include __DIR__ . DIRECTORY_SEPARATOR . "template/footer.php";
    ?>
<!--</body>

</html>-->