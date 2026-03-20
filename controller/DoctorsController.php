<?php
require_once '../models/specializations.php';

function handleSpecializationsRequest($conn) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnAdd'])) {
        $name = $_POST['name'];
        $desc = $_POST['description'];
        createSpecialization($conn, $name, $desc);
        header("Location: ../views/manage_specializations.php");
        exit();
    }


    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnEdit'])) {
        $id   = (int)$_POST['specialization_id'];
        $name = $_POST['name'];
        $desc = $_POST['description'];
        updateSpecialization($conn, $id, $name, $desc);
        header("Location: ../views/manage_specializations.php");
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnDelete'])) {
        $id = (int)$_POST['specialization_id'];
        deleteSpecialization($conn, $id);
        header("Location: ../views/manage_specializations.php");
        exit();
    }
}

function getSpecializations($conn) {
    if (isset($_GET['search'])) {
        $keyword = $_GET['keyword'] ?? '';
        return searchSpecializations($conn, $keyword);
    }
    return getAllSpecializations($conn);
}

function getSpecializationForEdit($conn) {
    if (isset($_GET['action']) && $_GET['action'] === 'edit') {
        $id = (int)$_GET['id'];
        return getSpecializationById($conn, $id);
    }
    return null;
}
?>
