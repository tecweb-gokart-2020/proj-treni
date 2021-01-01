<?php
namespace DB;
use mysqli;

class DBAccess {
    private const HOST_DB = "localhost";
    private const USERNAME = "lzaninot";
    // dovrebbe aprire il file con la password settato com path
    // assoluta in variabile d'ambiente, da vedere meglio dopo
    private $pw_file;
    private $pw_file_size;
    private const DB_NAME = "lzaninot";
    
    private $connection;

    public function __construct() {
        // soluzione meno elegante: pw.txt non versionato nella cartella
        $fname = 'pw.txt';
        $pw_file = fopen($fname);
        $pw_file_size = filesize($fname);
    }

    public function initDbConnection() {
        $password = fread($pw_file, $pw_file_size);
        $this->connection = mysqli_connect(DBAccess::HOST_DB,
                                           DBAccess::USERNAME,
                                           $password,
                                           DBAccess::DB_NAME);
        if(!$this->connection){
            error_log("Database not connected!!");
            return false;
        }
        return $this->connection;
    }

    public function openDbConnection() {
        // per evitare memory leak sulla stessa istanza di connessione
        if(!$this->connection) {
            return $this->initDbConnection();
        } else {
            return $this->connection;
        }
    }

    public function closeDbConnection() {
        mysqli_close($this->connection);
        $this->connection = null;
    }
}

$db = new DBAccess();
$connection = $db->openDbConnection();

?>
