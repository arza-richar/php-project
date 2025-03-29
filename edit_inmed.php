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

$id = $_GET['id']; // รับค่าจาก URL

// ค้นหาข้อมูลยาภายใน
$sql = "SELECT * FROM inmed_info WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $inmed_name = mysqli_real_escape_string($conn, $_POST['inmed_name']);
    $inmed_quantity = mysqli_real_escape_string($conn, $_POST['inmed_quantity']);
    $inmed_exdate = mysqli_real_escape_string($conn, $_POST['inmed_exdate']);

    // อัปเดตข้อมูลยาภายใน
    $update_sql = "UPDATE inmed_info SET inmed_name = ?, inmed_quantity = ?, inmed_exdate = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("sisi", $inmed_name, $inmed_quantity, $inmed_exdate, $id);
    
    if ($update_stmt->execute()) {
        header("Location: staffolly.php");
        exit();
    } else {
        echo "เกิดข้อผิดพลาด: " . $update_stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>แก้ไขข้อมูลยาภายใน</title>
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
            width: 100%; 
            max-width: 500px; 
            margin: 50px auto; 
            background-color: white; 
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        h2 {
            color: #333;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-size: 18px;
            color: #555;
        }
        input[type="text"], input[type="number"], input[type="date"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }
        .form-row {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 10px 0;
        }
        .form-row input {
            width: 80%;
        }
        button {
            width: 100%;
            padding: 15px;
            background-color: #f0ded4; /* สีพื้นหลัง */
            color: #156669; /* สีข้อความ */
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #e3d0b7;
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
        <a href="staffolly.php">การจัดการข้อมูลยา</a>
    </div>
</header>

<h2>แก้ไขข้อมูลยาภายใน</h2>

<div class="container">
    <form method="POST">
        <div class="form-row">
            <label for="inmed_name">ชื่อยา:</label>
            <input type="text" name="inmed_name" value="<?php echo $row['inmed_name']; ?>" required><br>
        </div>
        
        <div class="form-row">
            <label for="inmed_quantity">จำนวน:</label>
            <input type="number" name="inmed_quantity" value="<?php echo $row['inmed_quantity']; ?>" required><br>
        </div>
        
        <div class="form-row">
            <label for="inmed_exdate">วันหมดอายุ:</label>
            <input type="date" name="inmed_exdate" value="<?php echo $row['inmed_exdate']; ?>" required><br>
        </div>
        
        <button type="submit" name="save" class="submit-btn" 
                style="background-color: #f0ded4; color: #156669; padding: 10px 20px; 
                       border: none; border-radius: 5px; cursor: pointer; 
                       display: block; margin: 0 auto;">บันทึกข้อมูล</button>
    </form>
</div>

</body>
</html>

<?php $conn->close(); ?>