<?php
// File: API/profile.php
require_once("config.php");
require_once("../db_pdo.php");
session_start();

// Middleware: Kiểm tra đăng nhập
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(["message" => "Unauthorized"]);
    exit;
}

$user_id = $_SESSION['user_id'];

// --- GET: Lấy thông tin user ---
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        $stmt = $conn->prepare("SELECT id, name, email, avatar FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
        $user = $stmt->fetch();
        echo json_encode($user);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(["message" => $e->getMessage()]);
    }
    exit;
}

// --- POST: Cập nhật thông tin ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);

    if (!$input) {
        http_response_code(400);
        exit;
    }

    try {
        // Cập nhật Tên và Avatar
        $name = htmlspecialchars(strip_tags($input['name']));
        $avatar = htmlspecialchars(strip_tags($input['avatar']));

        $sql = "UPDATE users SET name = ?, avatar = ? WHERE id = ?";
        $params = [$name, $avatar, $user_id];

        // Nếu có đổi mật khẩu
        if (!empty($input['new_password'])) {
            $hashed_password = password_hash($input['new_password'], PASSWORD_DEFAULT);
            $sql = "UPDATE users SET name = ?, avatar = ?, password = ? WHERE id = ?";
            $params = [$name, $avatar, $hashed_password, $user_id];
        }

        $stmt = $conn->prepare($sql);
        $stmt->execute($params);

        echo json_encode(["status" => "success", "message" => "Cập nhật thành công!"]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(["status" => "error", "message" => $e->getMessage()]);
    }
    exit;
}
