<?php
// File: db_pdo.php

// Cấu hình Database (Tốt nhất nên lưu trong biến môi trường .env khi deploy thật)
$host = 'localhost';
$db   = 't2507e_db';
$user = 'root';
$pass = 'root'; // Mật khẩu của bạn (MAMP thường là root, XAMPP thường để trống)
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    // Báo lỗi dạng Exception để dễ bắt lỗi (try-catch)
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    // Luôn trả về dữ liệu dạng mảng kết hợp (key-value)
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    // Tắt tính năng giả lập Prepared Statements để bảo mật tối đa
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $conn = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    // Khi lỗi kết nối, trả về JSON lỗi 500 chứ không hiện lỗi PHP ra màn hình
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => "Database Connection Failed"]);
    exit;
}
?>