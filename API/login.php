<?php
// File: API/login.php
require_once("config.php");
require_once("../db_pdo.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$email = $input['email'] ?? '';
$password = $input['password'] ?? '';

try {
    $stmt = $conn->prepare("SELECT id, name, password FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        // Đăng nhập thành công
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];

        echo json_encode(["status" => "success", "user" => ["id" => $user['id'], "name" => $user['name']]]);
    } else {
        http_response_code(401);
        echo json_encode(["status" => "error", "message" => "Sai email hoặc mật khẩu"]);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["message" => $e->getMessage()]);
}
