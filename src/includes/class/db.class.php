<?php
namespace DB;
require_once __DIR__ . DIRECTORY_SEPARATOR . '../resources.php';
use mysqli;

class DBAccess {
    /* Ci rinuncio definitivamente, metto le mie credenziali di
     * default voi mettete le vostre per fare debug basta mi son
     * rotto sincero */
    private const HOST_DB = "localhost";
    private const USERNAME = "lzaninot";
    private const DB_NAME = "lzaninot";
    private const PASSWORD = "password";
    private const PORT = 3306;

    private $connection;

    public function initDbConnection() {        
        $this->connection = mysqli_connect(DBAccess::HOST_DB,
                                           DBAccess::USERNAME,
                                           DBAccess::PASSWORD,
                                           DBAccess::DB_NAME,
                                           DBAccess::PORT);
        if(!$this->connection){
            echo "Error: Unable to connect to MySQL." . HTML_EOL;
            echo "Debugging errno: " . mysqli_connect_errno() . HTML_EOL;
            echo "Debugging error: " . mysqli_connect_error() . HTML_EOL;
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
