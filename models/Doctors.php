<?php
require_once '../config/connectDB.php';

class Doctors {

    private $conn;

    public function __construct() {
        $db = new ConnectDB();
        $this->conn = $db->connection();
    }


    public function getAll() {
        $sql = "SELECT d.Doctor_ID, u.User_ID, u.FullName, u.Email, u.Phone
                FROM Doctors d
                JOIN Users u ON d.User_ID = u.User_ID";

        return $this->conn->query($sql);
    }


    public function create($username, $email, $password, $fullname, $phone) {

        $sqlUser = "INSERT INTO Users 
                    (UserName, Email, Password, FullName, Phone, UserType, Created_at)
                    VALUES (?, ?, ?, ?, ?, 'Doctor', NOW())";

        $stmt = $this->conn->prepare($sqlUser);
        $stmt->bind_param("sssss", $username, $email, $password, $fullname, $phone);
        $stmt->execute();

        $user_id = $this->conn->insert_id;


        $sqlDoctor = "INSERT INTO Doctors (ContactNumber, Created_at, User_ID)
                      VALUES (?, NOW(), ?)";

        $stmt2 = $this->conn->prepare($sqlDoctor);
        $stmt2->bind_param("si", $phone, $user_id);

        return $stmt2->execute();
    }

    public function delete($doctor_id) {


        $stmt = $this->conn->prepare("SELECT User_ID FROM Doctors WHERE Doctor_ID = ?");
        $stmt->bind_param("i", $doctor_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if (!$row) return false;

        $user_id = $row['User_ID'];

        $stmt2 = $this->conn->prepare("DELETE FROM Doctors WHERE Doctor_ID = ?");
        $stmt2->bind_param("i", $doctor_id);
        $stmt2->execute();

  
        $stmt3 = $this->conn->prepare("DELETE FROM Users WHERE User_ID = ?");
        $stmt3->bind_param("i", $user_id);

        return $stmt3->execute();
    }
}
?>
