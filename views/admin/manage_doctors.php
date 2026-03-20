<?php
session_start();
$username = $_SESSION['UserName'] ?? 'Admin';

require_once('../../config/connectDB.php');
require_once('../../controller/admin/doctorsController.php');

$db = new ConnectDB();
$conn = $db->connection();

$doctor_edit = null;
$doctor_edit = handleDoctorsRequest($conn);

$search_results = [];
if (isset($_GET['search'])) {
    $keyword = $_GET['keyword'] ?? '';
    $search_results = searchDoctors($conn, $keyword);
}

$doctors = !empty($search_results) ? $search_results : getAllDoctors($conn);


?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manage Doctors</title>
</head>
<body>

<h2>Xin chào, <?= htmlspecialchars($username) ?></h2>

<h3>Tìm kiếm bác sĩ</h3>
<form method="get">
<input type="text" name="keyword" placeholder="Từ khóa" value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>">
<button name="search">🔍 Tìm</button>
</form>

<h3>Danh sách bác sĩ</h3>

<table>
<tr>
    <th>UserName</th>
    <th>FullName</th>
    <th>Email</th>
    <th>Phone</th>
    <th>Hành động</th>
</tr>

<?php if (!empty($doctors)): ?>
    <?php foreach ($doctors as $row): ?>
    <tr>
        <td><?= htmlspecialchars($row['UserName'] ?? '') ?></td>
        <td><?= htmlspecialchars($row['FullName'] ?? '') ?></td>
        <td><?= htmlspecialchars($row['Email'] ?? '') ?></td>
        <td><?= htmlspecialchars($row['Phone'] ?? '') ?></td>
        <td>
            <a href="?action=edit&id=<?= $row['Doctor_ID'] ?>">✏️ Sửa</a>
            <form method="post" style="display:inline" onsubmit="return confirm('Xóa bác sĩ này?')">
                <input type="hidden" name="doctor_id" value="<?= $row['Doctor_ID'] ?>">
                <button name="btnDelete">🗑️ Xóa</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
<?php else: ?>
<tr><td colspan="5">Chưa có bác sĩ</td></tr>
<?php endif; ?>
</table>

<h3><?= $doctor_edit ? 'Sửa bác sĩ' : 'Thêm bác sĩ mới' ?></h3>
<form method="post">
<input type="hidden" name="doctor_id" value="<?= $doctor_edit['Doctor_ID'] ?? '' ?>">

<label>UserName: <input type="text" name="username" value="<?= htmlspecialchars($doctor_edit['UserName'] ?? '') ?>" required></label><br>
<label>FullName: <input type="text" name="fullname" value="<?= htmlspecialchars($doctor_edit['FullName'] ?? '') ?>" required></label><br>
<label>Email: <input type="email" name="email" value="<?= htmlspecialchars($doctor_edit['Email'] ?? '') ?>" required></label><br>
<label>Phone: <input type="text" name="phone" value="<?= htmlspecialchars($doctor_edit['Phone'] ?? '') ?>" required></label><br>

<?php if (!$doctor_edit): ?>
<label>Password: <input type="text" name="password" required></label><br>
<button name="btnAdd">➕ Thêm</button>
<?php else: ?>
<button name="btnEdit">💾 Cập nhật</button>
<?php endif; ?>
</form>

</body>
</html>
