<?php
namespace DB;
use mysqli;

class DBAccess {
    private const HOST_DB = "localhost";
    private const USERNAME = "lzaninot";
    // dovrebbe aprire il file con la password settato com path
    // assoluta in variabile d'ambiente, da vedere meglio dopo
    private const PASSWORD = fread(fopen($_ENV['PW_FILE']), filesize($_ENV['PW_FILE']));
    private const DB_NAME = "lzaninot";
    
    private $connection;

    public function initDbConnection() {
        $this->connection = mysqli_connect(DBAccess::HOST_DB,
                                           DBAccess::USERNAME,
                                           DBAccess::PASSWORD,
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
?>
