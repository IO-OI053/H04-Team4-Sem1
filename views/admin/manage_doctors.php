<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../authentication.php");
    exit;
}

$username = $_SESSION['username'] ?? 'Admin';

require_once('../config/connectDB.php');
$conn = ConnectDB::connection();

require_once('../controllers/doctorsController.php');


$row_edit = handleDoctorsRequest($conn);


$doctors = getAllDoctors($conn);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Quản lý Bác sĩ</title>
</head>
<body>

<nav class="admin-nav">
    <div class="nav-wrap">
        <h4>MediConnect | Admin</h4>
        <div class="nav-right">
            Xin chào <b><?= htmlspecialchars($username) ?></b>
            <a href="../logout.php" class="logout">Đăng xuất</a>
        </div>
    </div>
</nav>

<div class="layout">
<aside class="admin-side">
    <a class="side-link" href="admin_dashboard.php">Dashboard</a>
    <a class="side-link active" href="manage_doctors.php">Bác sĩ</a>
    <a class="side-link" href="manage_cities.php">Thành phố</a>
    <a class="side-link" href="manage_specializations.php">Chuyên khoa</a>
    <a class="side-link" href="admins.php">Admin</a>
</aside>

<main class="admin-main">

<h2>Quản lý Bác sĩ</h2>

<?php if ($row_edit): ?>
<div class="box">
<form method="post">
<input type="hidden" name="doctor_id" value="<?= $row_edit['Doctor_ID'] ?>">

<label>Họ tên:</label>
<input type="text" name="fullname" value="<?= htmlspecialchars($row_edit['FullName']) ?>">

<label>Email:</label>
<input type="email" name="email" value="<?= htmlspecialchars($row_edit['Email']) ?>">

<label>SĐT:</label>
<input type="text" name="phone" value="<?= htmlspecialchars($row_edit['Phone']) ?>">

<br><br>
<button type="submit" name="btnEdit" class="btn primary">Cập nhật</button>
<a href="manage_doctors.php" class="btn">Hủy</a>
</form>
</div>
<?php endif; ?>

<div class="box">
<h3>Thêm bác sĩ mới</h3>
<form method="post">
<input type="text" name="username" placeholder="Username" required>
<input type="text" name="fullname" placeholder="Họ tên" required>
<input type="email" name="email" placeholder="Email" required>
<input type="text" name="phone" placeholder="SĐT" required>
<input type="password" name="password" placeholder="Mật khẩu" required>
<button type="submit" name="btnAdd">Thêm</button>
</form>
</div>

<div class="box">
<table>
<tr>
    <th>ID</th>
    <th>Username</th>
    <th>Họ tên</th>
    <th>Email</th>
    <th>SĐT</th>
    <th>Thao tác</th>
</tr>

<?php if (!empty($doctors)): ?>
<?php foreach ($doctors as $row): ?>
<tr>
    <td><?= $row['Doctor_ID'] ?></td>
    <td><?= htmlspecialchars($row['UserName']) ?></td>
    <td><?= htmlspecialchars($row['FullName']) ?></td>
    <td><?= htmlspecialchars($row['Email']) ?></td>
    <td><?= htmlspecialchars($row['Phone']) ?></td>
    <td>
        <a href="manage_doctors.php?action=edit&id=<?= $row['Doctor_ID'] ?>">✏️</a>

        <form method="post" style="display:inline" onsubmit="return confirm('Xóa bác sĩ này?')">
            <input type="hidden" name="doctor_id" value="<?= $row['Doctor_ID'] ?>">
            <button name="btnDelete">🗑️</button>
        </form>
    </td>
</tr>
<?php endforeach; ?>
<?php else: ?>
<tr><td colspan="6">Chưa có bác sĩ</td></tr>
<?php endif; ?>

</table>
</div>

</main>
</div>

<footer class="admin-footer">
    © <?= date('Y') ?> MediConnect Admin Panel
</footer>
</body>
</html>
