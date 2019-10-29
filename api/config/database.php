<?php
namespace config;

class Database {
 
    // specify your own database credentials
    // private $host = "localhost";
    // private $db_name = "authentication";
    // private $username = "root";
    // private $password = "root";

    private $host = "mysql5021.site4now.net";
    private $db_name = "db_9c4ddd_auth";
    private $username = "9c4ddd_auth";
    private $password = "H@nnahN0ah";

    public $password_salt = "woolston";
    public $conn;
 
    // get the database connection
    public function getConnection() {
        try {
            $this->conn = new \PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            return $this->conn;
        } catch (\PDOException $e) {
            throw $e;
        }
    }
}
?>