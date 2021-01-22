<?php
namespace INDIRIZZO;
require_once __DIR__ . DIRECTORY_SEPARATOR . '../resources.php';
use mysqli;
use DB\DBAccess;
use function UTILITIES\isValidID;

// Ritorna l'ID dell'account associato ad un indirizzo, null se non esiste
function getAccountFromAddress($address_id){
    if(isValidID($address_id)){
        $dbAccess = new DBAccess();
        $connection = $dbAccess->openDbConnection();
        $query = "SELECT username FROM indirizzo WHERE addressID = \"$address_id\"";
        $queryResult = mysqli_query($connection, $query);
        $dbAccess->closeDbConnection();
        $account_id = mysqli_fetch_row($queryResult);
        return $account_id;
    }else{
        return false;
    }
}

// Ritorna un array associativo con i campi presenti in un indirizzo, null se non c'è alcun indirizzo
function getInfoFromAddress($address_id){
    if(isValidID($address_id)){
        $dbAccess = new DBAccess();
        $connection = $dbAccess->openDbConnection();
        $query = "SELECT nome, via, numero, citta, stato, provincia, cap, telefono
                  FROM indirizzo WHERE addressID = \"$address_id\"";
        $queryResult = mysqli_query($connection, $query);
        $infoIndirizzo = mysqli_fetch_assoc($queryResult);
        $dbAccess->closeDbConnection();
        return $infoIndirizzo;
    }else{
        return false;
    }
}

/* address mappa che rappresenta un indirizzo, se l'indirizzo è
 * presente nel db va tornato l'id, false altrimenti */
function address_exists($address) {
    $db = new DBAccess();
    $connection = $db->openDbConnection();
    $query = 'SELECT addresID FROM indirizzo WHERE nome="'. $address["nome"] . 
           '", cognome="'. $address["cognome"] . 
           '", via="'. $address["via"] . 
           '", civico="'. $address["numero"] . 
           '", citta="'. $address["citta"] . 
           '", provincia="'. $address["provincia"] . 
           '", cap="'. $address["cap"] . 
           '", stato="'. $address["stato"] . 
           '", telefono="'. $address["telefono"] . '"';
    $res = mysqli_query($connection, $query);
    if($res){
        return mysqli_affected_rows($res);
    }
    return false;
}


/* Address è una mappa che riporta le informazioni du un indirizzo. se
 * questo già esiste ritorna l'id, altrimenti lo inserisce e ne
 * ritorna l'id. ritorna false se la mappa è errata (campi non
 * validi) */
function getAddress($address, $user){
    $ID = address_exists($address);
    if($ID){
        return $ID;
    } else {
        $db = new DBAccess();
        $connection = $db->openDbConnection();
        $query = "SELECT addressID FROM indirizzo ORDER BY addressID DESC LIMIT 1";
        $queryResult = mysqli_query($connection, $query);
        $addressID = mysqli_fetch_row($queryResult)[0] + 1;
        //mamma mia che casino
	$query = 'INSERT INTO indirizzo(username, nome, cognome, via, numero, citta, provincia, cap, stato, telefono) VALUES ("'.
               $user . '", "' .
               $address["nome"] . '", "' .
               $address["cognome"] . '", "' .
               $address["via"] . '", "' .
               $address["numero"] . '", "' .
               $address["citta"] . '", "' .
               $address["provincia"] . '", "' .
               $address["cap"] . '", "' .
               $address["stato"] . '", "' .
               $address["telefono"] . '")';
	echo 'query: ';
        $queryResult = mysqli_query($connection, $query);
        $db->closeDbConnection();
        if($queryResult) {
            return '' . $addressID;
        }
        else {
            return false;
        }
    }
}

/*aggiunge un indirizzo, ritorna... qualcosa
Tutto l'input deve essere sanificato. In particolare, civico dovrebbe poter tenere le / (e telefono non dovrebbe avere spazi ma di questo se ne occupa la funzione)*/
function newAddress($username, $nome, $cognome, $via, $civico, $citta, $provincia, $cap, $telefono){
    /*convalida input
    sarei stato più permissivo sui nomi ma ci potrebbero essere problemi con la codifica dei caratteri speciali(òàùèé), quindi per ora va bene così.
    tutte le regex testate (qui: https://www.phpliveregex.com/) e funzionanti secondo la descrizione
    */
    $valid_username = preg_match("/^\w{3,}$/", $username);
    //se qualcuno usasse 2 nomi, ok
    $valid_nome = preg_match("/^[a-z]+( [a-z]+)*$/i", $nome);
    //permette "cognome", "articolo cognome", "articolo'cognome", "ricco-nobile-meglio di te"
    $valid_cognome = preg_match("/^[a-z]+(( |\'|\-)[a-z]+)*$/i", $cognome);
    //"tipoDiVia qualcosaAncheNumeriAbbreviazioniSigle..." poi - come separatore va anche bene
    $valid_via = preg_match("/^[a-z]+( [\w\.]+)*(( |\-)[\w\.]+)*$/i", $via);
    //il numero civico potrebbe avere simboli, spazi, trattini, barre, lettere... in qualsiasi ordine! stripslashes farebbe male qui
    $valid_civico = preg_match("/^[\w \.\-\\]+$/", $cognome);
    //solo lettere e parole aggiuntive precedute da spazio
    $valid_citta = preg_match("/^[a-z]+( [a-z]+)*$/i", $citta);
    //quando raggrupparono certe provincie, anni fa, presero i nomi e li separarono con -
    $valid_provincia = preg_match("/^[a-z]+(( |\-)[a-z]+)*$/i", $provincia);
    //5 cifre, ne più ne meno
    $valid_cap = preg_match("/^\d{5}$/", $cap);
    //prefisso internaz opzionale, fisso(prefisso 0123 numero, max 10 cifre tot) | cell(3... max 10 cifre); importante che non ci siano spazi
    //solo italici numeri, ho deciso. Così è meno generica
    $telefono = UTILITIES\removeWhitespaces($telefono);
    $valid_telefono = preg_match("/^((00|\+)39)?(0\d{5,9}|3\d{9})$/", $telefono);

    //connetti...

    //...ficca dentro...

    //...e disconnetti
}
?>
