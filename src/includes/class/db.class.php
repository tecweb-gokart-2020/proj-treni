<?php
namespace DB;
require_once __DIR__ . DIRECTORY_SEPARATOR . '../resources.php';
use mysqli;

class DBAccess {
    private const HOST_DB = "localhost";
    private const USERNAME = $_SERVER["LOGNAME"];
    /* Ci rinuncio, impostate come password "password"...*/
    private const PASSWORD = "password";
    private const DB_NAME = $_SERVER["LOGNAME"];
    private const PORT = 3306;

    private $connection;

    public function initDbConnection() {
        $this->connection = mysqli_connect($this->HOST_DB,
                                           $this->USERNAME,
                                           $this->PASSWORD,
                                           $this->DB_NAME,
                                           $this->PORT);
        if(!$this->connection){
            error_log("Database not connected!!");
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
