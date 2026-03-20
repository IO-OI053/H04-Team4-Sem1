<?php
session_start();
$username = $_SESSION['UserName'] ?? 'Admin';

require_once('../../config/connectDB.php');
require_once('../../controller/admin/CitiesController.php');

$conn = (new ConnectDB())->connection();

$city_edit = handleCitiesRequest($conn);
$cities = getCities($conn);  

?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Quản lý Thành phố</title>
</head>
<body>

<h2>Quản lý Thành phố</h2>

<?php if ($city_edit): ?>
<h3>Chỉnh sửa thành phố</h3>
<form method="post">
    <input type="hidden" name="city_id" value="<?= $city_edit['City_ID'] ?>">
    <label>Tên:</label><br>
    <input type="text" name="name" value="<?= htmlspecialchars($city_edit['Name']) ?>" required><br>
    <label>Khu vực:</label><br>
    <input type="text" name="region" value="<?= htmlspecialchars($city_edit['Region']) ?>" required><br>
    <button type="submit" name="btnEdit">Cập nhật</button>
    <a href="manage_cities.php">Hủy</a>
</form>
<?php else: ?>
<h3>Thêm thành phố mới</h3>
<form method="post">
    <label>Tên:</label><br>
    <input type="text" name="name" required><br>
    <label>Khu vực:</label><br>
    <input type="text" name="region" required><br>
    <button type="submit" name="btnAdd">Thêm</button>
</form>
<?php endif; ?>

<form method="get">
    <input type="text" name="keyword" placeholder="Tìm theo tên hoặc vùng" value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>">
    <button name="search">🔍 Tìm</button>
</form>
<table>
<tr>
    <th>Name</th>
    <th>Region</th>
    <th>Hành động</th>
</tr>

<?php if (!empty($cities)): ?>
    <?php foreach ($cities as $city): ?>
    <tr>
        <td><?= htmlspecialchars($city['Name']) ?></td>
        <td><?= htmlspecialchars($city['Region']) ?></td>
        <td>
            <a href="?action=edit&id=<?= $city['City_ID'] ?>">✏️ Sửa</a>
            <form method="post" style="display:inline" onsubmit="return confirm('Xóa thành phố này?')">
                <input type="hidden" name="city_id" value="<?= $city['City_ID'] ?>">
                <button name="btnDelete">🗑️ Xóa</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
<?php else: ?>
<tr><td colspan="3">Chưa có thành phố</td></tr>
<?php endif; ?>
</table>

</body>
</html>
