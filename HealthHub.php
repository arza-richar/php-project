<?php
// เชื่อมต่อฐานข้อมูล
$servername = "localhost";
$username = "root";
$password = "89898989";
$dbname = "healthhub";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ตรวจสอบการเข้าสู่ระบบ
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['login'])) {
        $stu_id = mysqli_real_escape_string($conn, $_POST['stu_id']); // ป้องกัน SQL Injection
        $sql = "SELECT * FROM stu_info WHERE stu_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $stu_id);  // Binding the parameter
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            session_start(); // เริ่ม session เพื่อเก็บข้อมูลผู้ใช้
            $_SESSION['stu_id'] = $stu_id; // เก็บรหัสนักเรียนใน session
            header("Location: student.php");
            exit();
        } else {
            $error_message = "ไม่พบข้อมูลในระบบ กรุณาสมัครสมาชิกก่อน";
        }
    }

    // ลงทะเบียน
    if (isset($_POST['register'])) {
        $stu_id = mysqli_real_escape_string($conn, $_POST['stu_id']);
        $stu_name = mysqli_real_escape_string($conn, $_POST['stu_name']);
        $stu_class = mysqli_real_escape_string($conn, $_POST['stu_class']);

        $sql = "INSERT INTO stu_info (stu_id, stu_name, stu_class) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $stu_id, $stu_name, $stu_class);  // Binding the parameters

        if ($stmt->execute()) {
            $success_message = "สมัครสมาชิกเรียบร้อยแล้ว";
        } else {
            $error_message = "เกิดข้อผิดพลาดในการสมัครสมาชิก";
        }
    }
}

// เริ่มต้น HTML
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>HealthHub</title>
    <style>
        body { 
            background-image: url('bg1.png'); 
            background-size: 100% 110%; 
            background-position: center; 
            background-repeat: no-repeat; 
            font-family: Arial, sans-serif;
        }
        .header {
            display: flex; 
            justify-content: space-between; 
            align-items: center;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.8);
        }
        .header img {
            height: 50px; 
            width: auto;  
        }
        .header .menu {
            display: flex; 
            justify-content: flex-end; 
        }
        .header .menu a {
            margin-left: 20px; 
            text-decoration: none; 
            color: #000; 
            font-weight: bold;
        }
        .container {
            width: 50%; 
            margin: auto; 
            padding: 20px;
            border-radius: 10px;
        }
        .form-group { margin-bottom: 15px; }
        .button { 
            padding: 16px; 
            background-color: #f0ded4; /* ใช้รหัสสีที่ถูกต้อง */
            color: #156669; 
            border: none; 
            cursor: pointer; 
            width: 20%; /* ให้ปุ่มขยายเต็มความกว้างของฟอร์ม */
            font-size: 16px; /* ขนาดตัวอักษร */
        }
        .error { color: red; }
        .success { color: green; }
    </style>
</head>
<body>

<header class="header">
    <img src="logo.png" alt="Logo">
    <div class="menu">
        <a href="contact.php">ติดต่อ</a>
        <a href="stafflogin.php">เจ้าหน้าที่</a> <!-- เปลี่ยนลิงก์ให้ถูกต้อง -->
    </div>
</header>

<div class="container" style="position: relative; left: 500px;">
    <h2>&nbsp;</h2>
    <h2 style="width: 45%; margin: auto; font-size: 20px;">เข้าสู่ระบบ</h2>
    <?php
    if (isset($error_message)) {
        echo "<p class='error'>$error_message</p>";
    }
    ?>
    <form method="POST">
        <div class="form-group">
            <label>รหัสนักเรียน :</label>
            <input type="text" name="stu_id" required style="width: 50%; padding: 10px; margin: 5px 0; border-radius: 5px; border: 1px solid #ccc;">
        </div>
        <button type="submit" name="login" class="button" 
        style="position: relative; top:0px; left: 180px;">เข้าสู่ระบบ</button>
    </form>

    <h2>&nbsp;</h2>
    <h2 style="width: 50%; margin: auto; font-size: 20px;">สมัครสมาชิก</h2>
    <?php
    if (isset($success_message)) {
        echo "<p class='success'>$success_message</p>";
    }
    ?>
    <form method="POST">
        <div class="form-group">
            <label>รหัสนักเรียน :</label>
            <input type="text" name="stu_id" required style="width: 50%; padding: 10px; margin: 5px 0; border-radius: 5px; border: 1px solid #ccc;">
        </div>
        <div class="form-group">
            <label>ชื่อ - สกุล :</label>
            <input type="text" name="stu_name" required style="width: 52%; padding: 10px; margin: 5px 0; border-radius: 5px; border: 1px solid #ccc;">
        </div>
        <div class="form-group">
            <label>ห้อง :</label>
            <input type="text" name="stu_class" required style="width: 56%; padding: 10px; margin: 5px 0; border-radius: 5px; border: 1px solid #ccc;">
        </div>
        <button type="submit" name="register" class="button" 
        style="position: relative; top:0px; left: 180px;">ลงทะเบียน</button>
    </form>
</div>

</body>
</html>

<?php
$conn->close();
?>
