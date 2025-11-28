<?php
//lấy được giá trị id từ đường dẫn (tham số trên URL)
$id = isset($_GET['id']);

//lấy dữ liệu từ db theo id đã lấy ở trên để cho vào form

//các thông số

$host = "localhost";
$user = "root";
$pwd = "root";
$db = "t2507e_db"; // Đảm bảo tên DB đúng với máy bạn

//Kết nối db

$conn = new mysqli($host, $user, $pwd, $db);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

//câu lệnh sql xóa dữ liệu
$sql = "DELETE FROM categories WHERE id=$id";
$result = $conn->query($sql);
?>