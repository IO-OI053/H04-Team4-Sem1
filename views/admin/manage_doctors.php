<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../client/login.php");
    exit;
}

$username = $_SESSION['username'] ?? 'Admin';

require_once '../../config/connectDB.php';

$conn = ConnectDB::connection();

if (isset($_REQUEST['btnDelete'])) {
    $user_id = (int)$_REQUEST['user_id'];

    $sql = "DELETE FROM Users WHERE User_ID = ? AND UserType = 'Admin'";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$user_id]);

    header("Location: admin.php");
    exit;
}

if (isset($_GET['action']) && $_GET['action'] === 'edit') {
    $user_id = (int)$_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM Users WHERE User_ID = ? AND UserType = 'Admin'");
    $stmt->execute([$user_id]);
    $row_edit = $stmt->fetch(PDO::FETCH_ASSOC);
}

if (isset($_REQUEST['btnEdit'])) {
    $user_id = (int)$_REQUEST['user_id'];
    $fullname = $_REQUEST['fullname'];
    $email = $_REQUEST['email'];
    $phone = $_REQUEST['phone'];

    $sql = "UPDATE Users 
            SET FullName = ?, Email = ?, Phone = ?
            WHERE User_ID = ? AND UserType = 'Admin'";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$fullname, $email, $phone, $user_id]);

    header("Location: admins.php");
    exit;
}

$stmt = $conn->prepare("SELECT * FROM Users WHERE UserType = 'Admin'");
$stmt->execute();
$admins = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Doctors</title>
    <style>
        body { font-family: Arial; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 10px; border: 1px solid #ccc; }
        input { margin: 5px; padding: 8px; }
    </style>
</head>
<body>

<h2>Quản lý Bác sĩ</h2>

<form method="POST">
    <input type="text" name="username" placeholder="Username" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <input type="text" name="fullname" placeholder="Họ tên" required>
    <input type="text" name="phone" placeholder="SĐT" required>
    <button type="submit" name="add">Thêm bác sĩ</button>
</form>

<br>

<table>
    <tr>
        <th>ID</th>
        <th>Họ tên</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Action</th>
    </tr>

    <?php while($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= $row['Doctor_ID'] ?></td>
        <td><?= $row['FullName'] ?></td>
        <td><?= $row['Email'] ?></td>
        <td><?= $row['Phone'] ?></td>
        <td>
            <a href="?delete=<?= $row['Doctor_ID'] ?>" onclick="return confirm('Xóa bác sĩ?')">
                Delete
            </a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

</body>
</html>
