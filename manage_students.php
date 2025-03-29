<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "89898989";
$dbname = "healthhub";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ฟังก์ชันอัปเดตข้อมูลนักเรียน
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $id = $_POST['stu_id'];
    $name = $_POST['stu_name'];
    $class = $_POST['stu_class'];
    
    $sql_update = "UPDATE stu_info SET stu_name='$name', stu_class='$class' WHERE id='$id'";
    if ($conn->query($sql_update) === TRUE) {
        echo "<script>alert('ข้อมูลถูกอัปเดตสำเร็จ');</script>";
    } else {
        echo "Error: " . $sql_update . "<br>" . $conn->error;
    }
}

// ดึงข้อมูลนักเรียนทั้งหมด
$sql = "SELECT * FROM stu_info";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>จัดการข้อมูลนักเรียน</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            text-align: center; 
            background-image: url('bg3.png'); /* ใส่ภาพพื้นหลัง */
            background-size: cover; /* ปรับขนาดให้พอดีกับหน้าจอ */
            background-position: center; /* จัดตำแหน่งให้อยู่ตรงกลาง */
            background-attachment: fixed; /* ทำให้พื้นหลังคงที่ขณะเลื่อน */
            margin: 0;
            padding: 0;
        }

        .container { 
            display: flex; 
            justify-content: center; 
            align-items: flex-start;
            margin-top: 20px;
            flex-wrap: wrap;
            gap: 20px;
        }

        .table-container { 
            width: 80%; 
            max-width: 800px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 8px;
        }

        .form-container { 
            width: 80%; 
            max-width: 800px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 8px;
        }

        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 20px; 
        }

        th, td { 
            border: 1px solid black; 
            padding: 10px; 
            text-align: left; 
            cursor: pointer; 
        }

        th { 
            background-color: #f2f2f2; 
        }

        input[type="text"] { 
            width: 100%; 
            padding: 10px; 
            margin: 5px 0; 
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        button { 
            padding: 10px 20px; 
            background-color: #f0ded4; 
            color: #156669; 
            border: none; 
            border-radius: 5px; 
            cursor: pointer; 
            display: block; 
            margin: 20px auto;
            font-size: 16px;
        }

        button:hover { 
            background-color: #e3d0b7; 
        }

        /* ปรับสไตล์ของ header */
        .header {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.8);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .header img {
            height: 50px;
            width: auto;
        }

        .header .menu {
            display: flex;
            justify-content: flex-end;
            margin-left: 1150px;
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
    <div class="menu">
        <a href="staffolly.php">การจัดการข้อมูลยา</a> <!-- เปลี่ยนลิงก์ให้ถูกต้อง -->
    </div>
</header>


<!-- Main content -->
<div class="container">
    <!-- แสดงตารางข้อมูลนักเรียน -->
    <div class="table-container">
        <h2>ข้อมูลนักเรียน</h2>
        <table>
            <thead>
                <tr><th>ID</th><th>ชื่อ</th><th>ชั้น</th></tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr onclick="selectStudent(<?php echo $row['id']; ?>, '<?php echo $row['stu_name']; ?>', '<?php echo $row['stu_class']; ?>')">
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['stu_name']; ?></td>
                        <td><?php echo $row['stu_class']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- ฟอร์มแก้ไขข้อมูลนักเรียน -->
    <div class="form-container">
        <h2>แก้ไขข้อมูลนักเรียน</h2>
        <form method="POST" action="">
            <input type="hidden" name="stu_id" id="stu_id">
            <label for="stu_name">ชื่อ-สกุล:</label>
            <input type="text" name="stu_name" id="stu_name" required>
            <label for="stu_class">ชั้น:</label>
            <input type="text" name="stu_class" id="stu_class" required>
            <button type="submit" name="update">อัปเดตข้อมูล</button>
        </form>
    </div>
</div>

<script>
// ฟังก์ชันที่ใช้ในการเลือกข้อมูลนักเรียนจากตาราง
function selectStudent(id, name, className) {
    document.getElementById('stu_id').value = id;
    document.getElementById('stu_name').value = name;
    document.getElementById('stu_class').value = className;
}
</script>

</body>
</html>

<?php
$conn->close();
?>