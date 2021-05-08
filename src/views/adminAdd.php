<?php

use function PRODOTTO\getInfoFromProdotto;
use function PRODOTTO\insertProdotto;
use function UTILITIES\isValidID;

session_start();
if($_SESSION["username"] == "admin") {
    $tag_info = "";
    $pagetitle = "Amministrazione";
    $pagedescription = "Area dove è possibile aggiungere un prodotto al catalogo";
    $js = '<script type="text/javascript" src="js/.js"></script>';
    include "template/header.php";

    $current_page = " >> Amministrazione";
    include "template/breadcrumb.php";

    if(isset($_POST["codArticolo"])){
        $prodotto = [
            "codArticolo" => $_POST["codArticolo"],
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
        unset($err);
        $err = "";
        if(!isValidID($_POST["codArticolo"]))
            $err .= "codArticolo non valido ";
        if(getInfoFromProdotto($_POST["codArticolo"]) != null)
            $err .= "Articolo già presente";
        if($err != "") {
            $_SESSION["addError"] = $err;
            echo $err;
            // header("Location: adminAdd.php");
            // exit();
        } else {
            if(insertProdotto($prodotto, $_FILES["immagine"])) {
                echo '<main id="content"><h1>Inserimento completato</h1><p>Inserimento andato a buon fine, è possibile vedere il nuovo prodotto nella
                     <a href="paginaSingoloProdotto.php?codArticolo=' . $_POST["codArticolo"] . '">pagina</a> corrispondente</p></main>';
            } else {
                echo '<main id="content"><h1>Inserimento errato</h1><p>Il prodotto non è stato inserito, ispezionare i log per capire cosa è successo</p></main>';
            }
        }
   } else {
        echo '<main id="content">
    <form id="insProd" name="insProd" action="adminAdd.php" method="post" novalidate="true">
        <fieldset><legend>Inserimento</legend>
            <label>Codice articolo
                <input type="number" name="codArticolo" required="required">
            </label>
            <label>Tipo
                <select name="tipo" required="required">
                    <option value="locomotiva">Locomotiva</option>
                    <option value="carrozza">Carrozza</option>
                    <option value="carro">Carro</option>
                    <option value="accessorio">Accessorio</option>
                    <option value="binari">Binari</option>
                </select>
            </label>
            <label>Descrizione
                <input type="text" name="descrizione" maxlength="100">
            </label>
            <label>Scala
                <input type="text" name="scala" maxlength="3">
            </label>
            <label>Amministrazione
                <input type="text" name="amministrazione" maxlength="3">
            </label>
            <label>Prezzo
                <input type="number" name="prezzo" required="required">
            </label>
            <label>Sconto
                <input type="number" name="sconto">
            </label>
            <label>Quantità
                <input type="number" name="quantita" min="1">
            </label>
            <label>Marca
                <input type="text" name="marca">
            </label>
            <label>Immagine
                <input type="file" name="immagine" required="required">
            </label>
            <input type="reset" value="Reset">
            <input type="submit" value="Inserisci">
        </fieldset>
    </form></main>';
    }
    include 'template/footer.php';
} else {
    $host  = $_SERVER['HTTP_HOST'];
    $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $extra = 'admin.php';
    header("Location: http://$host$uri/$extra");
    exit();
}
?>
