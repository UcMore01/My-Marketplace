<?php
class Database {
    private $host = "localhost";  // Change if needed
    private $user = "root";       // Your MySQL username
    private $pass = "";           // Your MySQL password
    private $db_name = "marketplace"; // Your database name
    private $conn;
    private static $instance = null;

    // Private constructor to prevent direct object creation
    private function __construct() {
        $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->db_name);
        
        // Check connection
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }

        // Set character encoding
        $this->conn->set_charset("utf8");
    }

    // Get an instance of the class (Singleton Pattern)
    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    // Get the database connection
    public function getConnection() {
        return $this->conn;
    }

    // Prevent object cloning
    private function __clone() {}

    // Close connection (Optional)
    public function closeConnection() {
        if ($this->conn) {
            $this->conn->close();
        }
    }

    public function beginTransaction(){

    }

    public function prepare($query){
        return $query;
    }
}

// Usage example in other PHP files:
// $db = Database::getInstance()->getConnection();
$conn = new Database();
?>
