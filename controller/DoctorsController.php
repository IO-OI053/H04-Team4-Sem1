<?php
require_once('../models/doctors.php');

function handleDoctorsRequest($conn) {

    if (isset($_POST['btnAdd'])) {
        $username = $_POST['username'];
        $email    = $_POST['email'];
        $password = $_POST['password'];
        $fullname = $_POST['fullname'];
        $phone    = $_POST['phone'];

        createDoctor($conn, $username, $email, $password, $fullname, $phone);
        header("Location: manage_doctors.php");
        exit();
    }

    if (isset($_POST['btnEdit'])) {
        $doctor_id = (int)$_POST['doctor_id'];
        $fullname  = $_POST['fullname'];
        $email     = $_POST['email'];
        $phone     = $_POST['phone'];

        updateDoctor($conn, $doctor_id, $fullname, $email, $phone);
        header("Location: manage_doctors.php");
        exit();
    }


    if (isset($_POST['btnDelete'])) {
        $doctor_id = (int)$_POST['doctor_id'];
        deleteDoctor($conn, $doctor_id);
        header("Location: manage_doctors.php");
        exit();
    }

    if (isset($_GET['action']) && $_GET['action'] === 'edit') {
        $doctor_id = (int)$_GET['id'];
        return getDoctorById($conn, $doctor_id);
    }

    return null;
}
?>
