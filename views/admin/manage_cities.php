<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../authentication.php");
    exit();
}

require_once '../config/connectDB.php';
require_once '../controllers/dashboard_controller.php';

$conn = (new ConnectDB())->connection();
$stats = handleDashboard($conn);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard</title>
<style>
body { font-family: Arial; margin: 20px; }
nav a { margin-right: 10px; text-decoration: none; }
.stats { display: flex; gap: 20px; margin-top: 20px; }
.card { padding: 20px; border: 1px solid #ccc; width: 150px; text-align: center; }
</style>
</head>
<body>

<header>
    <h1>Trang Quản Trị</h1>
    <p>Xin chào: <?= htmlspecialchars($_SESSION['username']) ?></p>
</header>

<nav>
    <a href="admin_dashboard.php">Dashboard</a>
    <a href="manage_users.php">Users</a>
    <a href="manage_doctors.php">Doctors</a>
    <a href="manage_patients.php">Patients</a>
</nav>

<div class="container">
    <h2>Thống kê hệ thống</h2>
    <div class="stats">
        <div class="card">
            <h3>Users</h3>
            <h2><?= $stats['users'] ?></h2>
        </div>
        <div class="card">
            <h3>Doctors</h3>
            <h2><?= $stats['doctors'] ?></h2>
        </div>
        <div class="card">
            <h3>Patients</h3>
            <h2><?= $stats['patients'] ?></h2>
        </div>
        <div class="card">
            <h3>Appointments</h3>
            <h2><?= $stats['appointments'] ?></h2>
        </div>
    </div>
</div>

</body>
</html>
