<?php
session_start();

// กำหนดรหัสสำหรับเจ้าหน้าที่
$correct_code = "1212312121";
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $entered_code = $_POST['staff_code'];

    // ตรวจสอบรหัส
    if ($entered_code === $correct_code) {
        // รหัสถูกต้อง, เชื่อมไปยังหน้าถัดไป
        header("Location: staffolly.php");
        exit();
    } else {
        // รหัสไม่ถูกต้อง, แสดงข้อความแจ้งเตือน
        $error_message = "รหัสไม่ถูกต้อง กรุณากรอกใหม่อีกครั้ง";
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>เข้าสู่ระบบเจ้าหน้าที่</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-image: url('bg3.png'); /* ใส่ภาพพื้นหลัง */
            background-size: cover; /* ปรับขนาดให้พอดีกับหน้าจอ */
            background-position: center; /* จัดภาพให้อยู่ตรงกลาง */
            background-repeat: no-repeat; /* ไม่ให้ภาพซ้ำ */
            background-attachment: fixed; /* ทำให้พื้นหลังไม่เลื่อนตาม */
        }

        /* ปรับสไตล์ของ header */
        .header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.8);
            z-index: 1000;
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
            color: #156669; /* สีข้อความที่กำหนด */
            font-weight: bold;
        }

        .header .menu a:hover {
            color: #45a049;
        }

        .container {
            text-align: center;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
            z-index: 999;
        }

        .container h2 {
            margin-bottom: 20px;
        }

        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }

        button:hover {
            background-color: #45a049;
        }

        p.error {
            color: red;
            font-size: 14px;
        }
    </style>
</head>
<body>

<!-- Header แถบข้างบน -->
<header class="header">
    <a href="HealthHub.php">
        <img src="logo.png" alt="Logo">
    </a>
    <div class="menu">
        <!-- You can add menu links here -->
    </div>
</header>

<!-- Main content for the staff login -->
<div class="container">
    <h2>กรอกรหัสเจ้าหน้าที่</h2>

    <?php if ($error_message): ?>
        <p class="error"><?php echo $error_message; ?></p>
    <?php endif; ?>

    <form method="POST">
        <label for="staff_code">กรอกรหัส:</label>
        <input type="password" id="staff_code" name="staff_code" required>
        <button type="submit">ยืนยัน</button>
    </form>
</div>

</body>
</html>