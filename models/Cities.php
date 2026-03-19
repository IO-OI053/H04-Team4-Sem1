<?php
require_once '../config/connectDB.php';

class Cities {

    private $conn;

    public function __construct() {
        $db = new ConnectDB();
        $this->conn = $db->connection();
    }

    public function getAll() {
        $sql = "SELECT * FROM Cities";
        return $this->conn->query($sql);
    }

    public function create($name, $region) {
        $sql = "INSERT INTO Cities (Name, Region) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ss", $name, $region);
        return $stmt->execute();
    }

    public function delete($id) {
        $sql = "DELETE FROM Cities WHERE City_ID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>
