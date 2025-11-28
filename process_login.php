<?php
session_start();
require_once("db_connect.php");

// Chỉ xử lý khi có request POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST['email'];
    $password = $_POST['password'];

    // 1. Validate dữ liệu đầu vào
    if (empty($email) || empty($password)) {
        $_SESSION['error'] = "Please enter both email and password!";
        header("Location: login.php");
        exit();
    }

    // 2. Tìm người dùng theo Email (Dùng Prepared Statement)
    // Ta chỉ cần lấy id, name và password (đã mã hóa) để kiểm tra
    $stmt = $conn->prepare("SELECT id, name, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // Tìm thấy email, lấy dữ liệu ra
        $user = $result->fetch_assoc();

        // 3. Xác thực mật khẩu (QUAN TRỌNG)
        // So sánh mật khẩu nhập vào ($password) với mật khẩu mã hóa trong DB ($user['password'])
        if (password_verify($password, $user['password'])) {

            // --- ĐĂNG NHẬP THÀNH CÔNG ---

            // Bảo mật: Tạo session ID mới để chống tấn công Session Fixation
            session_regenerate_id(true);

            // Lưu thông tin người dùng vào Session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['logged_in'] = true;

            // Chuyển hướng vào trang Dashboard/Trang chủ
            header("Location: index.php");
            exit();
        } else {
            // Sai mật khẩu
            $_SESSION['error'] = "Invalid password!";
            header("Location: login.php");
            exit();
        }
    } else {
        // Không tìm thấy Email
        $_SESSION['error'] = "User not found!";
        header("Location: login.php");
        exit();
    }

    $stmt->close();
    $conn->close();
} else {
    // Truy cập trái phép
    header("Location: login.php");
    exit();
}
