<?php
session_start();
require_once "../connect.php";

$db = new ConnectDB();
$conn = $db->connection();


if (isset($_POST['add'])) {

    $username = $_POST['username'];
    $email    = $_POST['email'];
    $password = $_POST['password'];
    $fullname = $_POST['fullname'];
    $phone    = $_POST['phone'];

    $sqlUser = "INSERT INTO Users (UserName, Email, Password, FullName, Phone, UserType, Created_at)
                VALUES (?, ?, ?, ?, ?, 'Doctor', NOW())";

    $stmt = $conn->prepare($sqlUser);
    $stmt->bind_param("sssss", $username, $email, $password, $fullname, $phone);
    $stmt->execute();

    $user_id = $conn->insert_id;

    $sqlDoctor = "INSERT INTO Doctors (ContactNumber, Created_at, User_ID)
                  VALUES (?, NOW(), ?)";

    $stmt2 = $conn->prepare($sqlDoctor);
    $stmt2->bind_param("si", $phone, $user_id);
    $stmt2->execute();
}

if (isset($_GET['delete'])) {
    $doctor_id = $_GET['delete'];


    $result = $conn->query("SELECT User_ID FROM Doctors WHERE Doctor_ID = $doctor_id");
    $row = $result->fetch_assoc();
    $user_id = $row['User_ID'];

    $conn->query("DELETE FROM Doctors WHERE Doctor_ID = $doctor_id");

    $conn->query("DELETE FROM Users WHERE User_ID = $user_id");
}

$sql = "SELECT d.Doctor_ID, u.FullName, u.Email, u.Phone, d.ContactNumber
        FROM Doctors d
        JOIN Users u ON d.User_ID = u.User_ID";

$result = $conn->query($sql);
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
