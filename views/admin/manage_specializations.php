<?php
session_start();
require_once '../../config/connectDB.php';
require_once '../../controller/admin/SpecializationsController.php';

$conn = (new ConnectDB())->connection();

$specialization_edit = handleSpecializationsRequest($conn);
$specializations = getSpecializations($conn);

?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Quản lý Chuyên khoa</title>
</head>
<body>

<h2>Quản lý Chuyên khoa</h2>
<form method="get">
    <input type="text"
           name="keyword"
           placeholder="Tìm kiếm..."
           value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>">
    <button type="submit">Tìm kiếm</button>
</form>

<?php if ($specialization_edit): ?>

<h3>Chỉnh sửa chuyên khoa</h3>

<form method="post">
    <input type="hidden"
           name="specialization_id"
           value="<?= $specialization_edit['Specialization_ID'] ?>">

    <label>Tên:</label><br>
    <input type="text"
           name="name"
           value="<?= htmlspecialchars($specialization_edit['Name']) ?>"
           required><br><br>

    <label>Mô tả:</label><br>
    <textarea name="description"><?= htmlspecialchars($specialization_edit['Description']) ?></textarea><br><br>

    <button type="submit" name="btnEdit">Cập nhật</button>
    <a href="manage_specializations.php">Hủy</a>
</form>

<?php else: ?>

<h3>Thêm chuyên khoa mới</h3>

<form method="post">
    <label>Tên:</label><br>
    <input type="text" name="name" required><br><br>

    <label>Mô tả:</label><br>
    <textarea name="description"></textarea><br><br>

    <button type="submit" name="btnAdd">Thêm</button>
</form>

<?php endif; ?>

<h3>Danh sách chuyên khoa</h3>

<table border="1" cellpadding="8" cellspacing="0">
    <tr>
        <th>ID</th>
        <th>Tên</th>
        <th>Mô tả</th>
        <th>Thao tác</th>
    </tr>

    <?php if (!empty($specializations)): ?>
        <?php foreach ($specializations as $row): ?>
            <tr>
                <td><?= $row['Specialization_ID'] ?></td>
                <td><?= htmlspecialchars($row['Name']) ?></td>
                <td><?= htmlspecialchars($row['Description']) ?></td>
                <td>
                    <a href="?action=edit&id=<?= $row['Specialization_ID'] ?>">✏️ Sửa</a>

                    <form method="post"
                          style="display:inline"
                          onsubmit="return confirm('Bạn chắc chắn muốn xoá?')">

                        <input type="hidden"
                               name="specialization_id"
                               value="<?= $row['Specialization_ID'] ?>">

                        <button type="submit" name="btnDelete">🗑️ Xóa</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="4">Không có dữ liệu</td>
        </tr>
    <?php endif; ?>

</table>

</body>
</html>
