<?php session_start();?>

<main id="contenuto"><!-- per il salto della navigazione -->
	<div id="loginContainer" class="container">
		<p><h1>Benvenuto!</h1>Accedi al tuo account</p>

		<form name="login" action="loginAct.php" method="post">
			<label> <strong>Nome utente o Email</strong>
				<input type="text" name="nomeUtente" id="loginUtente" maxlength="30"  autocomplete="on" required />
			</label>
			<label> <strong>Password</strong>
				<input type="password" name="password" id="loginPassword" maxlength="10" autocomplete="on" required  />
			</label>
			<!-- se c'è errore dal server, lo visualizza -->	
			<?php
				if(isset($_SESSION("loginErr"))){
					echo '<span class="errore">' . $_SESSION("loginErr") . '</span>';
					unset($_SESSION("loginErr"));
				}
			?>
			<input type="submit" id="loginInvio" value="Accedi" >
		</form>
		
		<div id="loginToRegistr" class="container">
			<p>Prima volta sul sito? <a href=""><strong>Registrati!</strong></a></p>
		</div>
	</div>
</main>