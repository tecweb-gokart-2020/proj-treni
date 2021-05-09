<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../includes/resources.php";
use DB\DBAccess;

session_start();
if(isset($_SESSION["username"])) {
    $tag_info = "";
    $pagetitle = "Elimina prodotto - Amministrazione";
    $pagedescription = "Interfaccia per la gestione dei prodotti del negozio";
    $js = '<script type="text/javascript" src="js/.js"></script>';
    include "template/header.php";

    $current_page = " >> Amministrazione";
    include "template/breadcrumb.php";

    $tag_info = "<span class=\"current_link\">";
    include "template/admin_navbar.php";
    
echo '
    <main id="content">
    	<form id="elimProd" name="elimProd" action="adminDelete.php" method="post" novalidate="true">
            <fieldset><legend>Elimina</legend>
                <label>Codice articolo
                    <input type="number" name="codice" required="true">
                </label>            
                <input type="submit" value="Elimina">
                <!-- chiedere conferma -->
            </fieldset>
        </form>
    </main>
';

include 'template/footer.php';
?>