<!DOCTYPE html>
<html>
    <head>
	<title><?=$pagetitle;?></title>
	<metaname="description" content="<?=$pagedescription;?>">
            <linkrel="stylesheet" type="text/css" href="styles/resource.css">
    </head>
    <body>
	<header>
	    <!-- Logo -->
	    <a href="/" id="banner"><h1>TrenoGheno</h1></a>
	    <!-- Ricerca -->
	    <form id="ricercaHeader" action="" method="get">
		<input type="search" id="searchQuery" name="searchQuery" placeholder="Cosa cerchi?" maxlength="40"/>
	    </form>
	    <!-- Login -->
	    <a href="heh">Login</a>
	    <!-- Carrello -->
	    <a href="huh">Carrello</a>
	    <!-- Menù -->
	    <nav>
		<ul>
		    <li>
			<!-- Test -->
			<a <?=$area_personale_link;?>>Area personale</a>
		    </li>
		    <li>
			<a <?=$notizie_link;?>>Notizie</a>
		    </li>
		    <li>
			<a <?=$prodotti_link;?>>Prodotti</a>
		    </li>				
		    <li>
			<a <?=$servizi_link;?>>Servizi</a>
		    </li>
		    <li>
			<a <?=$contatti_link;?>>Contatti</a>
		    </li>
		</ul>
	    </nav>
	</header>
