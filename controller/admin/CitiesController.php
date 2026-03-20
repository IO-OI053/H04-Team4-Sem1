<?php
require_once '../models/cities.php';

function handleCitiesRequest($conn) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnAdd'])) {
        $name = $_POST['name'];
        $region = $_POST['region'];
        createCity($conn, $name, $region);
        header("Location: ../views/manage_cities.php");
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnEdit'])) {
        $id = (int)$_POST['city_id'];
        $name = $_POST['name'];
        $region = $_POST['region'];
        updateCity($conn, $id, $name, $region);
        header("Location: ../views/manage_cities.php");
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnDelete'])) {
        $id = (int)$_POST['city_id'];
        deleteCity($conn, $id);
        header("Location: ../views/manage_cities.php");
        exit();
    }
}

function getCities($conn) {
    if (isset($_GET['search'])) {
        $keyword = $_GET['keyword'] ?? '';
        return searchCities($conn, $keyword);
    }
    return getAllCities($conn);
}

function getCityForEdit($conn) {
    if (isset($_GET['action']) && $_GET['action'] === 'edit') {
        $id = (int)$_GET['id'];
        return getCityById($conn, $id);
    }
    return null;
}
?>

