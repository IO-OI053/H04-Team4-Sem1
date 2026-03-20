<?php
session_start();
require_once '../config/connectDB.php';
require_once '../controllers/cities_controller.php';

$conn = (new ConnectDB())->connection();

handleCitiesRequest($conn);

$cities = getCities($conn);
$city_edit = getCityForEdit($conn);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Quản lý Thành phố</title>
<style>
body { font-family: Arial; margin: 20px; }
table { width: 100%; border-collapse: collapse; margin-top: 20px; }
th, td { padding: 10px; border: 1px solid #ccc; text-align: left; }
input[type=text] { width: 300px; padding: 5px; margin-bottom: 10px; }
button { padding: 5px 10px; margin-right: 5px; }
form { margin-bottom: 20px; }
</style>
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
    <input type="text" name="keyword" placeholder="Tìm kiếm..." value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>">
    <button type="submit" name="search">Tìm kiếm</button>
</form>

<table>
<tr>
    <th>ID</th>
    <th>Tên</th>
    <th>Khu vực</th>
    <th>Thao tác</th>
</tr>

<?php if (!empty($cities)): ?>
    <?php foreach ($cities as $row): ?>
        <tr>
            <td><?= $row['City_ID'] ?></td>
            <td><?= htmlspecialchars($row['Name']) ?></td>
            <td><?= htmlspecialchars($row['Region']) ?></td>
            <td>
                <a href="?action=edit&id=<?= $row['City_ID'] ?>">✏️ Sửa</a>
                <form method="post" style="display:inline" onsubmit="return confirm('Xóa thành phố này?')">
                    <input type="hidden" name="city_id" value="<?= $row['City_ID'] ?>">
                    <button name="btnDelete">🗑️ Xóa</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td colspan="4">Chưa có thành phố nào</td>
    </tr>
<?php endif; ?>
</table>

</body>
</html>
