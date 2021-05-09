<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "../../includes/resources.php";
use function UTILITIES\init_tag;

// init_tag($tag_info, '<a href="info.php">', $tag_info_close);
// init_tag($tag_ordini, '<a href="ordini.php">', $tag_ordini_close);
// init_tag($tag_indirizzi, '<a href="indirizzi.php">', $tag_indirizzi_close);

echo '<div id="percorso">
	<p>Ti trovi in: <a class="linkPercorso" id="linkHome" href="home.php" xml:lang="en" lang="en">Home</a> >> '. $current_page .'</p>
	</div>';
?>
