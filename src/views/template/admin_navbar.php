<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../../includes/resources.php";
use function UTILITIES\init_tag;

init_tag($tag_inserimento, '<a href="adminAdd.php">', $tag_inserimento_close);
init_tag($tag_modifica, '<a href="adminEdit.php">', $tag_modifica_close);
init_tag($tag_elimina, '<a href="adminDelete.php">', $tag_elimina_close);

echo '<nav id="admin_navbar" aria-label="Gestione prodotti">
    <ul>
        <li>
            '. $tag_inserimento .'
            Inserisci
            '. $tag_inserimento_close .'
        </li>
        <li>
            '. $tag_modifica .'
            Modifica
            '. $tag_modifica_close .'
        </li>
        <li>
            '. $tag_elimina .'
            Elimina
            '. $tag_elimina_close .'
        </li>
    </ul>
</nav>';
?>
