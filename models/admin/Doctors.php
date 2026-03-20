<?php
session_start();
require_once '../config/connectDB.php';
require_once('./models/doctors.php'); 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['btnAdd'])) {
        $username = $_POST['username'];
        $email    = $_POST['email'];
        $password = $_POST['password'];
        $fullname = $_POST['fullname'];
        $phone    = $_POST['phone'];

        createDoctor($conn, $username, $email, $password, $fullname, $phone);
        header("Location: ./views/admin/manage_doctors.php");
        exit();
    }

    if (isset($_POST['btnEdit'])) {
        $doctor_id = (int)$_POST['doctor_id'];
        $fullname  = $_POST['fullname'];
        $email     = $_POST['email'];
        $phone     = $_POST['phone'];

        updateDoctor($conn, $doctor_id, $fullname, $email, $phone);
        header("Location: ./views/admin/manage_doctors.php");
        exit();
    }

    if (isset($_POST['btnDelete'])) {
        $doctor_id = (int)$_POST['doctor_id'];
        deleteDoctor($conn, $doctor_id);
        header("Location: ./views/admin/manage_doctors.php");
        exit();
    }
}

$search_results = [];
if (isset($_GET['search'])) {
    $keyword = $_GET['keyword'] ?? '';
    $search_results = searchDoctors($conn, $keyword);
}


$doctors = getAllDoctors($conn);

$doctor_edit = null;
if (isset($_GET['action']) && $_GET['action'] === 'edit') {
    $id = (int)$_GET['id'];
    $doctor_edit = getDoctorById($conn, $id);
}
?>
