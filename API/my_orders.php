<?php
// File: API/my_orders.php
require_once("config.php");
require_once("../db_pdo.php");
session_start(); // Bắt buộc start session để lấy user_id

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405); exit;
}

// Kiểm tra đăng nhập (Giả sử login lưu user_id vào session)
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(["message" => "Unauthorized"]);
    exit;
}

$user_id = $_SESSION['user_id'];

try {
    // Nếu bảng orders chưa có cột user_id, bạn cần thêm vào DB trước:
    // ALTER TABLE orders ADD COLUMN user_id INT NULL;
    
    // Ở đây tạm thời lấy theo email nếu chưa có user_id liên kết, 
    // nhưng chuẩn nhất là query theo user_id.
    // Ví dụ giả định bạn đã update bảng orders:
    
    $stmt = $conn->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC");
    $stmt->execute([$user_id]);
    $orders = $stmt->fetchAll();

    echo json_encode($orders);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => $e->getMessage()]);
}
?>