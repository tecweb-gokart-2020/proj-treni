<?php
namespace DB;
require_once __DIR__ . DIRECTORY_SEPARATOR . '../resources.php';
use mysqli;

class DBAccess {
    
    public function __get($constName){
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
        case 'PASSWORD':
            $val = "password";
        }
        return $val;
    }
    
    private $connection;

    public function initDbConnection() {        
        $this->connection = mysqli_connect($this->HOST_DB,
                                           $this->USERNAME,
                                           $this->PASSWORD,
                                           $this->DB_NAME,
                                           $this->PORT);
        if(!$this->connection){
            echo "Error: Unable to connect to MySQL." . PHP_EOL;
            echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
            echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
            return false;
        }
        return $this->connection;
    }

    public function openDbConnection() {
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
