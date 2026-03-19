<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../authentication.php");
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

    header("Location: admin_dashboard.php");
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
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Quản lý Admin</title>
<link rel="stylesheet" href="admin.css">
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
    <a class="side-link" href="manage_doctors.php">Bác sĩ</a>
    <a class="side-link" href="manage_cities.php">Thành phố</a>
    <a class="side-link" href="manage_specializations.php">Chuyên khoa</a>
</aside>

<main class="admin-main">

<h2>Quản lý Admin</h2>

<?php if (isset($row_edit)): ?>
<div class="box">
<form method="post">

<input type="hidden" name="user_id" value="<?= $row_edit['User_ID'] ?>">

<label>Họ tên:</label>
<input type="text" name="fullname" value="<?= htmlspecialchars($row_edit['FullName']) ?>">

<label>Email:</label>
<input type="email" name="email" value="<?= htmlspecialchars($row_edit['Email']) ?>">

<label>SĐT:</label>
<input type="text" name="phone" value="<?= htmlspecialchars($row_edit['Phone']) ?>">

<br><br>
<button type="submit" name="btnEdit" class="btn primary">Cập nhật</button>
<a href="admins.php" class="btn">Hủy</a>

</form>
</div>
<?php endif; ?>

<div class="box">
<table>
<tr>
    <th>ID</th>
    <th>Username</th>
    <th>Họ tên</th>
    <th>Email</th>
    <th>SĐT</th>
    <th>Ngày tạo</th>
    <th>Thao tác</th>
</tr>

<?php if (!empty($admins)): ?>
<?php foreach ($admins as $row): ?>
<tr>
    <td><?= $row['User_ID'] ?></td>
    <td><?= htmlspecialchars($row['UserName']) ?></td>
    <td><?= htmlspecialchars($row['FullName']) ?></td>
    <td><?= htmlspecialchars($row['Email']) ?></td>
    <td><?= htmlspecialchars($row['Phone']) ?></td>
    <td><?= date('d/m/Y', strtotime($row['Created_at'])) ?></td>
    <td>
        <a href="admins.php?action=edit&id=<?= $row['User_ID'] ?>">
            ✏️
        </a>

        <form method="post" style="display:inline"
              onsubmit="return confirm('Xóa admin này?')">
            <input type="hidden" name="user_id" value="<?= $row['User_ID'] ?>">
            <button name="btnDelete">🗑️</button>
        </form>
    </td>
</tr>
<?php endforeach; ?>
<?php else: ?>
<tr>
    <td colspan="7">Chưa có admin</td>
</tr>
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
```
