<?php
session_start();

if (!isset($_SESSION['user_name'])) {
    header("Location: admin_dashboard.php");
    exit();
}

require_once '../../config/connectDB.php';

$db = new ConnectDB();
$conn = $db->connection();

function countTable($conn, $table) {
    $sql = "SELECT COUNT(*) AS total FROM $table";
    $result = $conn->query($sql);

    if ($result && $row = $result->fetch_assoc()) {
        return $row['total'];
    }
    return 0;
}

$totalUsers        = countTable($conn, "Users");
$totalDoctors      = countTable($conn, "Doctors");
$totalPatients     = countTable($conn, "Patients");
$totalAppointments = countTable($conn, "Appointments");

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>    
</head>

<body>

<header>
    <h1>Trang Quản Trị</h1>
    <p>Xin chào: <?php echo $_SESSION['user_name']; ?></p>
</header>

<nav>
    <a href="admin_dashboard.php">Dashboard</a>
    <a href="manage_users.php">Users</a>
    <a href="manage_doctors.php">Doctors</a>
    <a href="manage_patients.php">Patients</a>
    <!-- <a href="manage_appointments.php">Appointments</a>
    <a href="../logout.php">Logout</a> -->
</nav>

<div class="container">
    <h2>Thống kê hệ thống</h2>

    <div class="stats">

        <div class="card">
            <h3>Users</h3>
            <h2><?php echo $totalUsers; ?></h2>
        </div>

        <div class="card">
            <h3>Doctors</h3>
            <h2><?php echo $totalDoctors; ?></h2>
        </div>

        <div class="card">
            <h3>Patients</h3>
            <h2><?php echo $totalPatients; ?></h2>
        </div>

        <div class="card">
            <h3>Appointments</h3>
            <h2><?php echo $totalAppointments; ?></h2>
        </div>

    </div>
</div>

</body>
</html>
