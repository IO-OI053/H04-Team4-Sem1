<?php
session_start();
require_once "../connect.php";

$db = new ConnectDB();
$conn = $db->connection();


if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $desc = $_POST['description'];

    $sql = "INSERT INTO Specialization (Name, Description) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $name, $desc);
    $stmt->execute();
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM Specialization WHERE Specialization_ID = $id");
}


$result = $conn->query("SELECT * FROM Specialization");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Specializations</title>
    <style>
        body { font-family: Arial; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 10px; border: 1px solid #ccc; }
        textarea { width: 200px; height: 60px; }
    </style>
</head>
<body>

<h2>Quản lý Chuyên khoa</h2>

<form method="POST">
    <input type="text" name="name" placeholder="Tên chuyên khoa" required>
    <textarea name="description" placeholder="Mô tả"></textarea>
    <button type="submit" name="add">Thêm</button>
</form>

<table>
    <tr>
        <th>ID</th>
        <th>Tên</th>
        <th>Mô tả</th>
        <th>Action</th>
    </tr>

    <?php while($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= $row['Specialization_ID'] ?></td>
        <td><?= $row['Name'] ?></td>
        <td><?= $row['Description'] ?></td>
        <td>
            <a href="?delete=<?= $row['Specialization_ID'] ?>" onclick="return confirm('Xóa?')">Delete</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

</body>
</html>
