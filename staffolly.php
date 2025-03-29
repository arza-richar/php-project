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

$search = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search'])) {
    $search = mysqli_real_escape_string($conn, $_POST['search']);
}

$sql_exmed = "SELECT * FROM exmed_info WHERE exmed_name LIKE '%$search%'";
$sql_inmed = "SELECT * FROM inmed_info WHERE inmed_name LIKE '%$search%'";
$result_exmed = $conn->query($sql_exmed);
$result_inmed = $conn->query($sql_inmed);

// การลบข้อมูลจากฐานข้อมูล
if (isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];
    $table = $_POST['table'];

    if ($table == 'exmed') {
        $sql = "DELETE FROM exmed_info WHERE id = ?";
    } elseif ($table == 'inmed') {
        $sql = "DELETE FROM inmed_info WHERE id = ?";
    }

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $delete_id);
    
    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error";
    }

    $stmt->close();
    exit();
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>จัดการข้อมูลยา</title>
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
        .container { width: 80%; margin: auto; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; background-color: rgba(242, 242, 242, 0.6);}
        th, td { border: 1px solid black; padding: 10px; text-align: left; }
        .search-box { margin: 20px 0; }
        .add-btn {
    background-color: #59bb59;  /* สีพื้นหลังที่ต้องการ */
    color: #ffffff;  /* สีข้อความที่ต้องการ */
    border: none;
    padding: 6px 16px;
    cursor: pointer;
    font-size: 14px;
    border-radius: 6px;  /* ทำให้มุมปุ่มมน */
    transition: background-color 0.3s ease;  /* เพิ่มการเปลี่ยนแปลงสีเมื่อเอาเมาส์ไปวาง */
}

.add-btn:hover {
    background-color: #ffffff;  /* เปลี่ยนสีเมื่อเมาส์ไปวางที่ปุ่ม */
    
}
        .edit-btn, .delete-btn {
            padding: 5px 10px;
            cursor: pointer;
            border: none;
            color: white;
        }
        .edit-btn { background-color: orange; }
        .delete-btn { background-color: red; }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>

<header class="header">
    <a href="HealthHub.php">
        <img src="logo.png" alt="Logo">
    </a>
    <div class="menu">
        <a href="manage_students.php">จัดการข้อมูลนักเรียน</a>
        <a href="history.php">ประวัติเข้าใช้งาน</a>
    </div>
</header>

<h2>ระบบจัดการข้อมูลยา</h2>
<form method="POST" class="search-box">
    <input type="text" name="search" placeholder="ค้นหายา" value="<?php echo $search; ?>">
    <button type="submit">ค้นหา</button>
</form>

<div class="container">
    <h3>รายการยาภายนอก 
        <button class="add-btn" onclick="location.href='add_exmed.php'">➕</button>
    </h3>
    <table id="exmed_table">
        <tr>
            <th>ID</th><th>ชื่อยา</th><th>จำนวน</th><th>วันหมดอายุ</th><th>การจัดการ</th>
        </tr>
        <?php while ($row = $result_exmed->fetch_assoc()) { ?>
            <tr id="exmed_<?php echo $row['id']; ?>">
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['exmed_name']; ?></td>
                <td><?php echo $row['exmed_quantity']; ?></td>
                <td><?php echo $row['exmed_exdate']; ?></td>
                <td>
                    <button class="edit-btn" onclick="location.href='edit_exmed.php?id=<?php echo $row['id']; ?>'">แก้ไข</button>
                    <button class="delete-btn" onclick="deleteRow(<?php echo $row['id']; ?>, 'exmed')">ลบ</button>
                </td>
            </tr>
        <?php } ?>
    </table>

    <h3>รายการยาภายใน 
        <button class="add-btn" onclick="location.href='add_exmed.php'">➕</button>
    </h3>
    <table id="inmed_table">
        <tr>
            <th>ID</th><th>ชื่อยา</th><th>จำนวน</th><th>วันหมดอายุ</th><th>การจัดการ</th>
        </tr>
        <?php while ($row = $result_inmed->fetch_assoc()) { ?>
            <tr id="inmed_<?php echo $row['id']; ?>">
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['inmed_name']; ?></td>
                <td><?php echo $row['inmed_quantity']; ?></td>
                <td><?php echo $row['inmed_exdate']; ?></td>
                <td>
                    <button class="edit-btn" onclick="location.href='edit_inmed.php?id=<?php echo $row['id']; ?>'">แก้ไข</button>
                    <button class="delete-btn" onclick="deleteRow(<?php echo $row['id']; ?>, 'inmed')">ลบ</button>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>

<script>
function deleteRow(id, table) {
    if (confirm("คุณแน่ใจหรือไม่ว่าต้องการลบข้อมูลนี้?")) {
        $.ajax({
            url: "staffolly.php",  // ทำคำขอลบข้อมูลในหน้าเดียว
            type: "POST",
            data: { delete_id: id, table: table }, // ส่ง ID และ Table เพื่อระบุว่าต้องการลบอะไร
            success: function(response) {
                if (response == "success") {
                    $("#" + table + "_" + id).remove();  // ลบแถวจากตาราง
                } else {
                    alert("เกิดข้อผิดพลาดในการลบข้อมูล");
                }
            }
        });
    }
}
</script>

</body>
</html>
<?php $conn->close(); ?>