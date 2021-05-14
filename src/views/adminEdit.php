<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../includes/resources.php";
use function PRODOTTO\editProdotto;
use function PRODOTTO\getInfoFromProdotto;

session_start();


if($_SESSION["username"] == "admin") {

    $pagetitle = "Amministrazione";
    $pagedescription = "Pagina per la modifica dell'articolo " . $_GET['codArticolo'];
    $js = '<script type="text/javascript" src="js/.js"></script>';
    include "template/header.php";

    $current_page = "Amministrazione >> Modifica";
    include "template/breadcrumb.php";

    if ($_POST) {
        $prodotto = [
            "codArticolo" => $_GET["codArticolo"],
            "tipo" => $_POST["tipo"],
            "descrizione" => $_POST["descrizione"],
            "scala" => $_POST["scala"],
            "amministrazione" => $_POST["amministrazione"],
            "prezzo" => $_POST["prezzo"],
            "sconto" => $_POST["sconto"],
            "novita" => $_POST["novita"],
            "quantita" => $_POST["quantita"],
            "marca" => $_POST["marca"]
        ];
        if($_FILES["immagine"]){
            $target_dir = "./imgs/";
            $target_file = $target_dir . $prodotto["codArticolo"];
            $uploadOk = true;
            if(isset($_POST["submit"])) {
                $check = getimagesize($_FILES["immagine"]["tmp_name"]);
                if($check !== false) {
                    echo "File is an image - " . $check["mime"] . ".";
                    $uploadOk = true;
                } else {
                    echo "File is not an image.";
                    $uploadOk = false;
                }
            }
            if($uploadOk) {
                $moveOk = move_uploaded_file($_FILES["immagine"]["tmp_name"], $target_file);
            }
        }

        if(editProdotto($prodotto)){
            echo '<main id="content"><h2>Modifica avvenuta con successo</h2>L\'articolo '
                . $prodotto['codArticolo'] .
                ' è stato modificato con successo, è possibile vedere le modifiche nella <a href="paginaSingoloProdotto.php?codArticolo='
                . $prodotto['codArticolo'] .
                '">pagina relativa</a></main>';
        } else {
            echo '<main id="content"><h2>LOOOOOL Non funziona</h2></main>';
        }
    }
    else {
        $prodotto = getInfoFromProdotto($_GET["codArticolo"]);
        if ($prodotto) {
            echo '<form id="modProd" name="modProd" action="adminEdit.php?codArticolo='. $prodotto["codArticolo"] .'" method="post" novalidate="true" enctype="multipart/form-data">
            <fieldset><legend>Modifica ' . $prodotto["codArticolo"] . '</legend>
                <label>Tipo
                    <select name="tipo" >
                        <option value="locomotiva"' . ($prodotto["tipo"] == "locomotiva" ? 'selected="selected"' : "") . '>Locomotiva</option>
                        <option value="carrozza"' . ($prodotto["tipo"] == "carrozza" ? 'selected="selected"' : "") . '>Carrozza</option>
                        <option value="carro"' . ($prodotto["tipo"] == "carro" ? 'selected="selected"' : "") . '>Carro</option>
                        <option value="accessorio"' . ($prodotto["tipo"] == "accessorio" ? 'selected="selected"' : "") . '>Accessorio</option>
                        <option value="binario"' . ($prodotto["tipo"] == "binario" ? 'selected="selected"' : "") . '>Binari</option>
                    </select>
                </label>
                <label>Descrizione
                    <input type="textarea" name="descrizione" value="' . $prodotto["descrizione"] . '" maxlength="100">
                </label>
                <label>Scala
                    <input type="text" name="scala" value="' . $prodotto["scala"] . '" maxlength="3">
                </label>
                <label>Amministrazione
                    <input type="text" name="amministrazione" value="' . $prodotto["amministrazione"] . '" maxlength="3">
                </label>
                <label>Prezzo
                    <input type="number" name="prezzo" value="' . $prodotto["prezzo"] . '">
                </label>
                <label>Sconto
                    <input type="number" name="sconto" value="' . $prodotto["sconto"] . '">
                </label>
                <label>Quantità
                    <input type="number" name="quantita" value="' . $prodotto["quantita"] . '">
                </label>
                <label>Marca
                    <input type="text" name="marca" value="' . $prodotto["marca"] . '">
                </label>
                <label>Novità
                    <input type="checkbox" name="novita" value="'. $prodotto['novita'] .'">
                </label>
                <label>Immagine
                    <input type="file" name="immagine">
                </label>
                <input type="reset" value="Reset">                
                <input type="submit" value="Modifica">
            </fieldset>
        </form>';
        } else {
            echo '<main><h2>404</h2>L\'articolo selezionato non esiste</main>';
        }
    }
    include 'template/footer.php';
}
?>
