<?php
require_once '../config/connectDB.php';

$conn = (new ConnectDB())->connection();

function getAllSpecializations($conn) {
    $sql = "SELECT * FROM Specialization ORDER BY Specialization_ID DESC";
    return $conn->query($sql);
}

function getSpecializationById($conn, $id) {
    $sql = "SELECT * FROM Specialization WHERE Specialization_ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function createSpecialization($conn, $name, $desc) {
    $sql = "INSERT INTO Specialization (Name, Description) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $name, $desc);
    return $stmt->execute();
}

function updateSpecialization($conn, $id, $name, $desc) {
    $sql = "UPDATE Specialization SET Name = ?, Description = ? WHERE Specialization_ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $name, $desc, $id);
    return $stmt->execute();
}

function deleteSpecialization($conn, $id) {
    $sql = "DELETE FROM Specialization WHERE Specialization_ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}

function searchSpecializations($conn, $keyword) {
    $keyword = "%$keyword%";
    $sql = "SELECT * FROM Specialization WHERE Name LIKE ? OR Description LIKE ? ORDER BY Specialization_ID DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $keyword, $keyword);
    $stmt->execute();
    return $stmt->get_result();
}
?>
