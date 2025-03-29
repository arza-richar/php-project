<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "89898989";
$dbname = "healthhub";

// เชื่อมต่อฐานข้อมูล
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ตรวจสอบว่ามี session หรือไม่
if (!isset($_SESSION['stu_id'])) {
    header("Location: HealtHub.php");
    exit();
}

$stu_id = $_SESSION['stu_id'];

// ดึงข้อมูลนักเรียนจากฐานข้อมูล
$sql = "SELECT stu_name, stu_class FROM stu_info WHERE stu_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $stu_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $stu_name = $row['stu_name'];
    $stu_class = $row['stu_class'];
} else {
    $stu_name = "ไม่พบข้อมูล";
    $stu_class = "ไม่พบข้อมูล";
}

// ดึงข้อมูลยาจากฐานข้อมูล
$inmed_options = "";
$exmed_options = "";

// ยารับประทาน
$sql = "SELECT inmed_name FROM inmed_info";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    $inmed_options .= "<option value='" . $row['inmed_name'] . "'>" . $row['inmed_name'] . "</option>";
}

// ยาภายนอก
$sql = "SELECT exmed_name FROM exmed_info";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    $exmed_options .= "<option value='" . $row['exmed_name'] . "'>" . $row['exmed_name'] . "</option>";
}

// ตรวจสอบการกดปุ่มบันทึก
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save'])) {
    $stucondition = $_POST['stucondition'];
    $treatment = $_POST['treatment'];
    $medicine = $_POST['medicine'];
    $dose = $_POST['dose'];
    $date = date("Y-m-d");
    $time = date("H:i:s");

    // บันทึกข้อมูลลงในฐานข้อมูล
    $sql = "INSERT INTO service_info (date, time, stuid, stuname, stuclass, stucondition, treatment, medicine, dose) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssi", $date, $time, $stu_id, $stu_name, $stu_class, $stucondition, $treatment, $medicine, $dose);
    
    if ($stmt->execute()) {
        echo "<script>
                alert('บันทึกข้อมูลสำเร็จ!');
                window.location.href = 'HealthHub.php';
              </script>";
        exit();
    } else {
        echo "<script>alert('เกิดข้อผิดพลาด กรุณาลองใหม่');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>HealthHub - หน้าหลัก</title>
    <style>
        body { 
            background-image: url('bg3.png'); 
            background-size: 100% 175%; 
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
        .header .user-info {
            font-weight: bold;
        }
        .container {
            width: 50%;
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            font-weight: bold;
        }
        .form-group input, .form-group select, .form-group textarea {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .submit-btn {
            background-color: green;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
        }

    </style>
</head>
<body>

<!-- Header แถบข้างบน -->
<header class="header">
    <a href="HealthHub.php">
        <img src="logo.png" alt="Logo">
    </a>
    </div>
    <div class="user-info">
        <p>รหัสนักเรียน: <?php echo htmlspecialchars($stu_id); ?> | 
           ชื่อ: <?php echo htmlspecialchars($stu_name); ?> | 
           ห้อง: <?php echo htmlspecialchars($stu_class); ?></p>
    </div>
</header>

<!-- Content -->
<div class="container">
    <h2 style="text-align: center; font-size: 28px; font-weight: bold; margin-top: 20px;">
    กรอกข้อมูลการรักษา</h2>
    <form method="POST">
        <div class="form-group">
            <label>อาการ:</label>
            <textarea name="stucondition" required></textarea>
        </div>
        <div class="form-group">
            <label>ประเภทการรักษา:</label>
            <select name="treatment" required>
                <option value="">เลือกประเภทการรักษา</option>
                <option value="รับยาตามอาการ">รับยาตามอาการ</option>
                <option value="ทำแผล">ทำแผล</option>
                <option value="นอนพัก">นอนพัก</option>
            </select>
        </div>
        <div class="form-group">
            <label>ยาในการรักษา:</label>
            <select name="medicine" required>
                <option value="">เลือกยาในการรักษา</option>
                <optgroup label="ยารับประทาน">
                    <?php echo $inmed_options; ?>
                </optgroup>
                <optgroup label="ยาทาภายนอก">
                    <?php echo $exmed_options; ?>
                </optgroup>
            </select>
        </div>
        <div class="form-group">
            <label>จำนวนยา:</label>
            <input type="number" name="dose" min="1" required>
        </div>
        <button type="submit" name="save" class="submit-btn" 
        style="background-color: #f0ded4; color: #156669; padding: 10px 20px; 
               border: none; border-radius: 5px; cursor: pointer; 
               display: block; margin: 0 auto;">บันทึกข้อมูล</button>

    </form>
</div>

</body>
</html>

<?php
$conn->close();
?>