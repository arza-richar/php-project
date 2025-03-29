<?php 
session_start();
$servername = "localhost";
$username = "root";
$password = "89898989";
$dbname = "healthhub";

// เชื่อมต่อกับฐานข้อมูล
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$exmed_msg = "";
$inmed_msg = "";

// ตรวจสอบการส่งฟอร์ม
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // เพิ่มข้อมูลยาภายนอก
    if (isset($_POST['submit_exmed'])) {
        $exmed_name = mysqli_real_escape_string($conn, $_POST['exmed_name']);
        $exmed_quantity = mysqli_real_escape_string($conn, $_POST['exmed_quantity']);
        $exmed_exdate = mysqli_real_escape_string($conn, $_POST['exmed_exdate']);
        
        // เพิ่มข้อมูลในตาราง exmed_info
        $sql = "INSERT INTO exmed_info (exmed_name, exmed_quantity, exmed_exdate) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sis", $exmed_name, $exmed_quantity, $exmed_exdate);
        
        if ($stmt->execute()) {
            $exmed_msg = "เพิ่มข้อมูลยาภายนอกเรียบร้อยแล้ว";
        } else {
            $exmed_msg = "เกิดข้อผิดพลาด: " . $stmt->error;
        }
    }
    
    // เพิ่มข้อมูลยาภายใน
    if (isset($_POST['submit_inmed'])) {
        $inmed_name = mysqli_real_escape_string($conn, $_POST['inmed_name']);
        $inmed_quantity = mysqli_real_escape_string($conn, $_POST['inmed_quantity']);
        $inmed_exdate = mysqli_real_escape_string($conn, $_POST['inmed_exdate']);
        
        // เพิ่มข้อมูลในตาราง inmed_info
        $sql = "INSERT INTO inmed_info (inmed_name, inmed_quantity, inmed_exdate) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sis", $inmed_name, $inmed_quantity, $inmed_exdate);
        
        if ($stmt->execute()) {
            $inmed_msg = "เพิ่มข้อมูลยาภายในเรียบร้อยแล้ว";
        } else {
            $inmed_msg = "เกิดข้อผิดพลาด: " . $stmt->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>เพิ่มข้อมูลยา</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            text-align: center; 
            background-image: url('bg3.png'); /* ใส่ภาพพื้นหลัง */
            background-size: cover; /* ปรับขนาดให้พอดีกับหน้าจอ */
            background-position: center; /* จัดตำแหน่งให้อยู่ตรงกลาง */
            background-attachment: fixed; /* ทำให้พื้นหลังคงที่ขณะเลื่อน */
        }

        .container { 
            width: 80%; 
            margin: auto; 
        }

        form { 
            margin-bottom: 30px; 
            border: 1px solid #ccc; 
            padding: 20px; 
            border-radius: 10px; 
        }

        input[type="text"], input[type="number"], input[type="date"] {
            padding: 10px; 
            width: 80%; 
            margin: 10px 0; 
            border-radius: 5px; 
            border: 1px solid #ccc;
        }

        button {
            padding: 10px 20px; 
            background-color: #4CAF50; 
            color: white; 
            border: none; 
            cursor: pointer;
        }

        .msg { 
            color: green; 
        }

        /* ปรับสไตล์ของ header */
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
            color: #156669; /* สีข้อความที่กำหนด */
            font-weight: bold;
        }

        .header .menu a:hover {
            color: #45a049;
        }
    </style>
</head>
<body>
    <!-- ส่วนของ header -->
    <header class="header">
        <a href="HealthHub.php">
            <img src="logo.png" alt="Logo">
        </a>
        <div class="menu">
            <a href="staffolly.php">การจัดการข้อมูลยา</a> <!-- เปลี่ยนลิงก์ให้ถูกต้อง -->
        </div>
    </header>

    <h2>เพิ่มข้อมูลยา</h2>
    <div class="container">
        <!-- ฟอร์มเพิ่มข้อมูลยาภายนอก -->
        <h3>เพิ่มข้อมูลยาภายนอก</h3>
        <?php if ($exmed_msg != "") { echo "<p class='msg'>$exmed_msg</p>"; } ?>
        <form method="POST" action="add_exmed.php">
            <input type="text" name="exmed_name" placeholder="ชื่อยา" required><br>
            <input type="number" name="exmed_quantity" placeholder="จำนวน" required><br>
            <input type="date" name="exmed_exdate" placeholder="วันหมดอายุ" required><br>
            <button type="submit" name="submit_exmed"style="background-color: #f0ded4; color: #156669; padding: 10px 20px; 
               border: none; border-radius: 5px; cursor: pointer; 
               display: block; margin: 0 auto;">บันทึกข้อมูล</button>
        </form>

        <!-- ฟอร์มเพิ่มข้อมูลยาภายใน -->
        <h3>เพิ่มข้อมูลยาภายใน</h3>
        <?php if ($inmed_msg != "") { echo "<p class='msg'>$inmed_msg</p>"; } ?>
        <form method="POST" action="add_exmed.php">
            <input type="text" name="inmed_name" placeholder="ชื่อยา" required><br>
            <input type="number" name="inmed_quantity" placeholder="จำนวน" required><br>
            <input type="date" name="inmed_exdate" placeholder="วันหมดอายุ" required><br>
            <button type="submit" name="submit_inmed"style="background-color: #f0ded4; color: #156669; padding: 10px 20px; 
               border: none; border-radius: 5px; cursor: pointer; 
               display: block; margin: 0 auto;">บันทึกข้อมูล</button>
        </form>
    </div>
</body>
</html>

<?php
$conn->close();
?>