<!-- ส่วนของ header -->
<header class="header">
    <a href="HealthHub.php">
        <img src="logo.png" alt="Logo">
    </a>
</header>

<style>
    /* ปรับพื้นหลังของทั้งหน้าเว็บ */
    body {
        background-image: url('bg2.png'); /* เปลี่ยนเป็นรูปที่ต้องการ */
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
    }

    /* ปรับสไตล์ของ header */
    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px;
        background-color: white; /* เปลี่ยนสีพื้นหลังเป็นขาว */
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* เพิ่มเงาให้ header */
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
        color: #156669; /* สีข้อความ */
        font-weight: bold;
    }

    .header .menu a:hover {
        color: #45a049;
    }
</style>