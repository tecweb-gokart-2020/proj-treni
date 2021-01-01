<?php
namespace DB;
use mysqli;

class DBAccess {
    private const HOST_DB = "localhost";
    private const USERNAME = $_SERVER["LOGNAME"];
    // dovrebbe aprire il file con la password settato com path
    // assoluta in variabile d'ambiente, da vedere meglio dopo
    private $pw_file;
    private const DB_NAME = $_SERVER["LOGNAME"];
    private const PORT = 3306;
    
    private $connection;

    public function initDbConnection() {
        $fname = $_SERVER['PW_FILE'];
        $pw_file = fopen($fname, 'r');
        $pw_file_size = filesize($fname);

        $password = str_replace("\n", "", fread($pw_file, $pw_file_size));
        
        $this->connection = mysqli_connect(DBAccess::HOST_DB,
                                           DBAccess::USERNAME,
                                           $password,
                                           DBAccess::DB_NAME,
                                           DBAccess::PORT);
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
