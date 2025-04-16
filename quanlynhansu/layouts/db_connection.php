<?php
$host = "localhost";
$username = "root"; // Thay đổi nếu cần
$password = ""; // Thay đổi nếu cần
$dbname = "quanly_nhansu";

// Kết nối đến cơ sở dữ liệu
$conn = mysqli_connect($host, $username, $password, $dbname);

// Kiểm tra kết nối
if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}
?>