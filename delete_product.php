<?php
// 1. Kết nối Database
require_once("db_connect.php");

// 2. Kiểm tra xem có ID được gửi lên không
if (isset($_GET['id'])) {

    // 3. Lấy ID và ép kiểu số nguyên (Bảo mật: chống SQL Injection)
    $id = intval($_GET['id']);

    // 4. Tạo câu lệnh SQL Xóa
    // CỰC KỲ QUAN TRỌNG: Luôn phải có WHERE id = ...
    $sql = "DELETE FROM products WHERE id = $id";

    // 5. Thực thi
    if ($conn->query($sql) === TRUE) {
        // Thành công -> Quay về trang danh sách
        header("Location: products.php");
        exit();
    } else {
        // Thất bại (Thường do ràng buộc khóa ngoại - sẽ giải thích bên dưới)
        echo "Lỗi: Không thể xóa danh mục này. <br>";
        echo "Nguyên nhân: " . $conn->error;
        echo "<br><a href='products.php'>Quay lại danh sách</a>";
    }
} else {
    // Nếu không có ID -> Quay về trang danh sách
    header("Location: products.php");
    exit();
}
