<?php
$servername = "localhost"; // Địa chỉ máy chủ MySQL
$username = "root";        // Tên đăng nhập MySQL (thay đổi nếu cần)
$password = "";            // Mật khẩu MySQL (thay đổi nếu cần)
$dbname = "atd_mng_system"; // Tên database

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
?>
    