<main id="contenuto"><!-- per il salto della navigazione -->
	<div id="registrContainer" class="container">
		<div class="container">
			<p><h1>Crea account</h1>Inserisci i dati per registrarti su Trenogheno.it. I campi contrassegnati con * sono obbligatori.</p>

			<form name="registr" action="" method="post">
				<label>Email *
					<input type="email" name="email" id="registrEmail" maxlength="100" autocomplete="on" required />
				</label>
				<label>Nome Utente *<br/>Minimo 3 caratteri
					<input type="text" name="nomeUtente" id="registrUtente" maxlength="20" required/>
				</label>
				<label>Password *<br/>Massimo 10 caratteri
					<input type="password" name="password" id="registrPassword" maxlength="10" required/>
				</label>
				<label>Conferma password *
					<input type="password" name="password2" id="registrPassword2" maxlength="10" required/>
				</label>
				<!-- tengo per copia incolla o riferimento
				<label>Nome *
					<input type="text" name="nome" id="registrNome" maxlength="50" required/>
				</label>
				<label>Cognome *
					<input type="text" name="cognome" id="registrCognome" maxlength="50" required/>
				</label>
				<label>Via *
					<input type="text" name="via" id="registrVia" maxlength="50" required/>
				</label>				
				<label>Numero civico *
					<input type="text" name="civico" id="registrCivico" maxlength="50" required/>
				</label>
				<label>Città *
					<input type="text" name="citta" id="registrCitta" maxlength="50" required/>
				</label>				
				<label>Provincia *
					<input type="text" name="provincia" id="registrProvincia" maxlength="50" required/>
				</label>				
				<label> <abbr title="Codice Avviamento Postale">CAP</abbr> *
					<input type="text" name="cap" id="registrCap" maxlength="5" required/>
				</label>
				<label>Stato *
					<input type="text" name="stato" id="registrStato" maxlength="50" value="Italia" required/>
				</label>
				<label>Telefono
					<input type="text" name="telefono" maxlength="20" />
				</label>
				-->
				<?php //mostra errore dal server
					if(isset($_SESSION("registerErr"))){
						echo '<span class="errore">' . $_SESSION("registerErr") . '</span>';
						unset($_SESSION("registerErr")); //reset errore
					}
				?>
				<input type="submit" value="Registrati"/>
			</form>

			<div id="RegistrToLogin" class="container">
				<p>Già registrato? <a href=""><strong>Accedi!</strong></a></p>
			</div>	
		</div>
	</div>
</main>