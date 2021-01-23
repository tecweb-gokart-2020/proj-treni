<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../../includes/resources.php";
use function UTILITIES\init_tag;

init_tag($tag_info, '<a href="info.php">', $tag_info_close);
init_tag($tag_ordini, '<a href="ordini.php">', $tag_ordini_close);

echo '<nav id="ap_navbar">
    <ul>
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
    </ul>
</nav>';
?>
