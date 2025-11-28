<?php
$host = "localhost";
$user = "root";
$pwd = "root";
$db = "t2507e_db"; // Đảm bảo tên DB đúng với máy bạn

$conn = new mysqli($host, $user, $pwd, $db);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
?>