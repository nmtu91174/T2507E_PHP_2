<?php
// File: update_product.php
require_once("db_connect.php");

// Kiểm tra phương thức POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 1. Nhận dữ liệu từ Form
    // Chú ý: Phải nhận cả ID từ thẻ input hidden
    $id = intval($_POST['id']);
    $name = $_POST['name'];
    $price = floatval($_POST['price']);
    $qty = intval($_POST['qty']);
    $thumbnail = $_POST['thumbnail'];
    $category_id = intval($_POST['category_id']);
    $description = $_POST['description'];

    // 2. Validation (Kiểm tra cơ bản)
    if (empty($name) || empty($id)) {
        die("Thiếu thông tin quan trọng!");
    }

    // 3. Làm sạch dữ liệu (Sanitization)
    $name = $conn->real_escape_string($name);
    $thumbnail = $conn->real_escape_string($thumbnail);
    $description = $conn->real_escape_string($description);

    // 4. Câu lệnh UPDATE
    $sql = "UPDATE products SET 
                name = '$name',
                price = $price,
                qty = $qty,
                thumbnail = '$thumbnail',
                category_id = $category_id,
                description = '$description'
            WHERE id = $id"; // Đừng bao giờ quên WHERE id

    // 5. Thực thi và Điều hướng
    if ($conn->query($sql) === TRUE) {
        // Thành công: Quay về trang danh sách
        header("Location: products.php");
        exit();
    } else {
        echo "Lỗi Update: " . $conn->error;
        echo "<br><a href='edit_product.php?id=$id'>Quay lại sửa</a>";
    }
} else {
    // Nếu ai đó cố truy cập trực tiếp file này mà không bấm Submit
    header("Location: products.php");
}
