<?php
require_once __DIR__ . DIRECOTRY_SEPARATOR . "../../includes/resources.php";
use function UTILITY\init_tag;

init_tag($tag_info, '<a href="info.php">', $tag_info_close);
init_tag($tag_ordini, '<a href="ordini.php">', $tag_ordini_close);
init_tag($tag_indirizzi, '<a href="indirizzi.php">', $tag_indirizzi_close);
echo '
<nav class="navbar">
    <ul class="navbar-nav">
             <li>
            '. $tag_info .'
                Informazioni personali
            '. $tag_info_close .'
        </li>
	<li>
            '. $tag_ordini .'
		I miei ordini
            '. $tag_ordini_close .'
	</li>
	<li>
            '. $tag_indirizzi .'
		I miei indirizzi
            '. $tag_indirizzi_close .'
	</li>
    </ul>
</nav>';
?>
