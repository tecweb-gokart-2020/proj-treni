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
	    <a href="/index.php" id="banner"><h1>TrenoGheno</h1></a>
	    <!-- Ricerca -->
	    <form id="ricercaHeader" action="" method="get">
		<input type="search" id="searchQuery" name="searchQuery" placeholder="Cosa cerchi?" maxlength="40"/>
	    </form>
	    <!-- Login -->
	    <a href="/views/login.php">Login</a>
	    <!-- Carrello -->
	    <a href="/views/carrello.php">Carrello</a>
	    <!-- Menù -->
	    <nav>
		<ul>
		    <li>
			<!-- Test -->
			<a "/views/info.php">Area personale</a>
		    </li>
		    <li>
			<a "/views/prodotti.php?novita">Notizie</a>
		    </li>
		    <li>
			<a "/views/prodotti.php">Prodotti</a>
		    </li>				
		    <li>
			<a "/views/prodotti.php">Servizi</a>
		    </li>
		    <li>
			<a "/views/contatti.php">Contatti</a>
		    </li>
		</ul>
	    </nav>
	</header>
