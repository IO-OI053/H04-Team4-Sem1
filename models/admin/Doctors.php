<?php
require_once('../../config/connectDB.php');

$conn = (new ConnectDB())->connection();

function createDoctor($conn, $username, $email, $password, $fullname, $phone, $contactNumber) {

    $sqlUser = "INSERT INTO Users (UserName, Email, Password, FullName, Phone, Created_at) VALUES (?, ?, ?, ?, ?, NOW())";
    $stmtUser = $conn->prepare($sqlUser);
    $stmtUser->bind_param("sssss", $username, $email, $password, $fullname, $phone);
    $stmtUser->execute();


    $user_id = $conn->insert_id;


    $sqlDoctor = "INSERT INTO Doctors (ContactNumber, Created_at, User_ID) VALUES (?, NOW(), ?)";
    $stmtDoctor = $conn->prepare($sqlDoctor);
    $stmtDoctor->bind_param("si", $contactNumber, $user_id);
    return $stmtDoctor->execute();
}


function updateDoctor($conn, $doctor_id, $fullname, $email, $phone, $contactNumber) {

    $sqlGetUser = "SELECT User_ID FROM Doctors WHERE Doctor_ID = ?";
    $stmtGetUser = $conn->prepare($sqlGetUser);
    $stmtGetUser->bind_param("i", $doctor_id);
    $stmtGetUser->execute();
    $result = $stmtGetUser->get_result()->fetch_assoc();
    if (!$result) return false;
    $user_id = $result['User_ID'];


    $sqlUser = "UPDATE Users SET FullName = ?, Email = ?, Phone = ? WHERE User_ID = ?";
    $stmtUser = $conn->prepare($sqlUser);
    $stmtUser->bind_param("sssi", $fullname, $email, $phone, $user_id);
    $stmtUser->execute();


    $sqlDoctor = "UPDATE Doctors SET ContactNumber = ? WHERE Doctor_ID = ?";
    $stmtDoctor = $conn->prepare($sqlDoctor);
    $stmtDoctor->bind_param("si", $contactNumber, $doctor_id);
    return $stmtDoctor->execute();
}


function deleteDoctor($conn, $doctor_id) {
    $sqlGetUser = "SELECT User_ID FROM Doctors WHERE Doctor_ID = ?";
    $stmtGetUser = $conn->prepare($sqlGetUser);
    $stmtGetUser->bind_param("i", $doctor_id);
    $stmtGetUser->execute();
    $result = $stmtGetUser->get_result()->fetch_assoc();
    if (!$result) return false;
    $user_id = $result['User_ID'];


    $sqlDoctor = "DELETE FROM Doctors WHERE Doctor_ID = ?";
    $stmtDoctor = $conn->prepare($sqlDoctor);
    $stmtDoctor->bind_param("i", $doctor_id);
    $stmtDoctor->execute();


    $sqlUser = "DELETE FROM Users WHERE User_ID = ?";
    $stmtUser = $conn->prepare($sqlUser);
    $stmtUser->bind_param("i", $user_id);
    return $stmtUser->execute();
}

function getAllDoctors($conn) {
    $sql = "SELECT d.Doctor_ID, d.ContactNumber, u.User_ID, u.UserName, u.FullName, u.Email, u.Phone
            FROM Doctors d
            JOIN Users u ON d.User_ID = u.User_ID
            WHERE u.User_ID > 1
            ORDER BY d.Doctor_ID DESC";
    $result = $conn->query($sql);

    $doctors = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $doctors[] = $row;
        }
    }
    return $doctors;
}

function searchDoctors($conn, $keyword) {
    $keyword = "%$keyword%";
    $sql = "SELECT d.Doctor_ID, d.ContactNumber, u.User_ID, u.UserName, u.FullName, u.Email, u.Phone
            FROM Doctors d
            JOIN Users u ON d.User_ID = u.User_ID
            WHERE (u.FullName LIKE ? OR u.UserName LIKE ? OR u.Email LIKE ?) AND u.User_ID > 1
            ORDER BY d.Doctor_ID DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $keyword, $keyword, $keyword);
    $stmt->execute();
    return $stmt->get_result();
}

function getDoctorById($conn, $doctor_id) {
    $sql = "SELECT d.Doctor_ID, d.ContactNumber, u.User_ID, u.UserName, u.FullName, u.Email, u.Phone
            FROM Doctors d
            JOIN Users u ON d.User_ID = u.User_ID
            WHERE d.Doctor_ID = ? AND u.User_ID > 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $doctor_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}
