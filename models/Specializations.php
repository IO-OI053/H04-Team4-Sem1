<?php
require_once '../config/connectDB.php';

class Specializations {

    private $conn;

    public function __construct() {
        $db = new ConnectDB();
        $this->conn = $db->connection();
    }

 
    public function getAll() {
        $sql = "SELECT * FROM Specialization";
        return $this->conn->query($sql);
    }

  
    public function create($name, $desc) {
        $sql = "INSERT INTO Specialization (Name, Description) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ss", $name, $desc);
        return $stmt->execute();
    }

    public function delete($id) {
        $sql = "DELETE FROM Specialization WHERE Specialization_ID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>
