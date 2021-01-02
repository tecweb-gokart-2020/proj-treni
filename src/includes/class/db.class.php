<?php
namespace DB;
use mysqli;

class DBAccess {
    // private const HOST_DB = "localhost";
    // private const USERNAME = $_SERVER["LOGNAME"];
    private $pw_file;
    // private const DB_NAME = $_SERVER["LOGNAME"];
    // private const PORT = 3306;

    private function __get($constName){
        $val = null;
        switch($constName) {
        case 'HOST_DB':
            $val = 'localhost';
            break;
        case 'USERNAME':
            $val = $_SERVER["LOGNAME"];
            break;
        case 'DB_NAME':
            $val = $_SERVER["LOGNAME"];
            break;
        case 'PORT':
            $val = 3306;
            break;
        }
        return $val;
    }
    
    private $connection;

    public function initDbConnection() {
        $fname = $_SERVER["HOME"] . "pwd_db_2020-21.txt";
        $pw_file = fopen($fname, 'r');
        $pw_file_size = filesize($fname);

        $password = str_replace("\n", "", fread($pw_file, $pw_file_size));
        
        $this->connection = mysqli_connect($this->HOST_DB,
                                           $this->USERNAME,
                                           $password,
                                           $this->DB_NAME,
                                           $this->PORT);
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
