<?php

use function PRODOTTO\getInfoFromProdotto;
use function PRODOTTO\insertProdotto;
use function UTILITIES\isValidID;

session_start();
if (isset($_SESSION["username"])) {
    if ($_SESSION["username"] == "admin") {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $tag_add = "";
        }
        $pagetitle = "Aggiungi prodotto - Amministrazione";
        $pagedescription = "Area dove è possibile aggiungere un prodotto al catalogo";
        $js = '<script type="text/javascript" src="js/adminAdd.js"></script>';
        include "template/header.php";

        $current_page = "Amministrazione";
        include "template/breadcrumb.php";

        $phpFileUploadErrors = array(
             1 => 'Dimensione del file troppo grande, la dimensione massima è 2MB',
             2 => 'file troppo grande, dimensione massima 2MB',
             3 => 'File uploadato solo parzialmente, riprovare',
             4 => 'File non ricevuto correttamente, riprovare',
             6 => 'Nessuna cartella temporanea, contattare il gestore del servizio',
             7 => 'Impossibile scrivere sul disco, contattare il gestore del servizio',
             8 => 'Un\'estensione ha annullato il caricamento del file, riprovare più tardi',
         );

        if (isset($_POST["codArticolo"])) {
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
            if (!isValidID($_POST["codArticolo"])) {
                $err .= "codice articolo non valido";
            }
            if (getInfoFromProdotto($_POST["codArticolo"]) != null) {
                $err .= "articolo già presente";
            }
            if ($err != "") {
                echo '<main id="content"><h1>Inserimento errato</h1><p>Non è stato possibile inserire l\'articolo descritto: '. $err .'</p></main>';
            } else {
                if ($_FILES["immagine"]["error"] === 0 && insertProdotto($prodotto, $_FILES["immagine"])) {
                    echo '<main id="content"><h1>Inserimento completato</h1><p>Inserimento andato a buon fine, è possibile vedere il nuovo prodotto nella
                         <a href="paginaSingoloProdotto.php?codArticolo=' . $_POST["codArticolo"] . '">pagina</a> corrispondente</p></main>';
                } else {
                    echo '<main id="content"><h1>Inserimento errato</h1><p>Non è stato possibile inserire l\'articolo descritto: '. $phpFileUploadErrors[$_FILES["immagine"]["error"]].'</p></main>';
                }
            }
        } else {
            echo '<main id="content">
        <form enctype="multipart/form-data" id="insProd" name="insProd" action="adminAdd.php" method="post" novalidate="novalidate" aria-live="assertive">
            <fieldset><legend>Inserimento</legend>
                <label>Codice articolo*
                    <input type="number" id="insProdCod" name="codArticolo" required="required" aria-errormessage="errorCodice" aria-invalid="false">
                </label>
                <div id="errorCodice" class="errore nascosto" >Questo campo è obbligatorio!</div>
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
                    <textarea name="descrizione" maxlength="500"></textarea>
                </label>
                <label>Scala
                    <input type="text" name="scala" maxlength="3">
                </label>
                <label>Amministrazione
                    <input type="text" name="amministrazione" maxlength="3">
                </label>
                <label>Prezzo*
                    <input type="number" id="insProdPrezzo" name="prezzo" required="required" aria-errormessage="errorPrezzo" aria-invalid="false">
                </label>
                <div id="errorPrezzo" class="errore nascosto" >Questo campo è obbligatorio!</div>
                <label>Sconto
                    <input type="number" name="sconto" value="0">
                </label>
                <label>Quantità
                    <input type="number" name="quantita" value="1" min="1">
                </label>
                <label>Marca
                    <input type="text" name="marca">
                </label>
                <label>Immagine* (dimensione massima: 2MB)
                    <input type="file" id="insProdImg" name="immagine" required="required" aria-errormessage="errorImmagine" aria-invalid="false">
                </label>
                <div id="errorImmagine" class="errore nascosto" >Scegli un\'immagine da caricare</div>
                <div class="button-pair">
                  <input type="reset" value="Reset">
                  <input id="new-item-insert-button" type="submit" value="Inserisci">
                </div>
            </fieldset>
        </form></main>';
        }
        include 'template/footer.php';
    } else {
        $host  = $_SERVER['HTTP_HOST'];
        $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        $extra = 'home.php';
        header("Location: http://$host$uri/$extra");
        exit();
    }
} else {
    $host  = $_SERVER['HTTP_HOST'];
    $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $extra = 'login.php';
    header("Location: http://$host$uri/$extra");
    exit();
}
