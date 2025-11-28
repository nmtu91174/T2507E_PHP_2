<?php
session_start();
require_once("db_connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Nhận dữ liệu
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    // 2. Validation (Kiểm tra dữ liệu)
    if (empty($name) || empty($email) || empty($password)) {
        $_SESSION['error'] = "All fields are required!";
        header("Location: register.php");
        exit();
    }

    if ($password !== $confirm_password) {
        $_SESSION['error'] = "Passwords do not match!";
        header("Location: register.php");
        exit();
    }

    // 3. Kiểm tra Email đã tồn tại chưa
    // Sử dụng Prepared Statement để an toàn hơn
    $check_email = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check_email->bind_param("s", $email);
    $check_email->execute();
    $check_email->store_result();

    if ($check_email->num_rows > 0) {
        $_SESSION['error'] = "Email already exists! Please use another one.";
        header("Location: register.php");
        exit();
    }
    $check_email->close();

    // 4. Mã hóa mật khẩu (Password Hashing) - QUAN TRỌNG NHẤT
    // PASSWORD_DEFAULT sẽ dùng thuật toán bcrypt mạnh nhất hiện tại
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // 5. Insert vào Database
    $sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name, $email, $hashed_password);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Registration successful! You can now login.";
        // Chuyển hướng sang trang login (nếu chưa có thì về lại register để xem thông báo)
        header("Location: register.php");
    } else {
        $_SESSION['error'] = "System error: " . $stmt->error;
        header("Location: register.php");
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: register.php");
}
