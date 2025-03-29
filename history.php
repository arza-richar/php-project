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

// ดึงข้อมูลจากตาราง service_info
$sql = "SELECT * FROM service_info";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ประวัติการใช้งาน</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            text-align: center; 
            background-image: url('bg3.png'); /* ใส่ภาพพื้นหลัง */
            background-size: cover; /* ปรับขนาดให้พอดีกับหน้าจอ */
            background-position: center; /* จัดตำแหน่งให้อยู่ตรงกลาง */
            background-attachment: fixed; /* ทำให้พื้นหลังคงที่ขณะเลื่อน */
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

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: rgba(242, 242, 242, 0.6);
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
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

<!-- ตารางข้อมูลจาก service_info -->
<div>
    <h1>ประวัติการใช้งาน</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>วันที่</th>
                <th>เวลา</th>
                <th>รหัสนักเรียน</th>
                <th>ชื่อนักเรียน</th>
                <th>ชั้นเรียน</th>
                <th>อาการ</th>
                <th>การรักษา</th>
                <th>ยา</th>
                <th>ขนาดยา</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['date']; ?></td>
                    <td><?php echo $row['time']; ?></td>
                    <td><?php echo $row['stuid']; ?></td>
                    <td><?php echo $row['stuname']; ?></td>
                    <td><?php echo $row['stuclass']; ?></td>
                    <td><?php echo $row['stucondition']; ?></td>
                    <td><?php echo $row['treatment']; ?></td>
                    <td><?php echo $row['medicine']; ?></td>
                    <td><?php echo $row['dose']; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

</body>
</html>

<?php
$conn->close();
?>