<?php
// File: API/upload.php
require_once("config.php"); // Load CORS và Config

// 1. Chỉ nhận method POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["message" => "Method Not Allowed"]);
    exit;
}

// 2. Kiểm tra file gửi lên
if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
    http_response_code(400);
    echo json_encode(["message" => "Không có file hoặc file bị lỗi (Mã lỗi: " . $_FILES['image']['error'] . ")"]);
    exit;
}

$file = $_FILES['image'];

// --- CẤU HÌNH BẢO MẬT & LƯU TRỮ ---

// 3. Tạo đường dẫn thư mục theo Năm/Tháng (Ví dụ: ../uploads/2025/11/)
$sub_folder = date("Y/m/");
$base_dir = "../uploads/";
$target_dir = $base_dir . $sub_folder;

// Tạo thư mục đệ quy nếu chưa tồn tại
if (!file_exists($target_dir)) {
    if (!mkdir($target_dir, 0755, true)) { // 0755 an toàn hơn 0777
        http_response_code(500);
        echo json_encode(["message" => "Lỗi không thể tạo thư mục lưu trữ."]);
        exit;
    }
}

// 4. Validate định dạng (Extension)
$file_ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
$allowed_ext = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

if (!in_array($file_ext, $allowed_ext)) {
    http_response_code(400);
    echo json_encode(["message" => "Chỉ cho phép định dạng ảnh (JPG, PNG, WEBP)."]);
    exit;
}

// 5. Validate nội dung thật của file (MIME Type) - QUAN TRỌNG
// Ngăn chặn hacker đổi tên file .php thành .jpg để upload
$finfo = new finfo(FILEINFO_MIME_TYPE);
$mime_type = $finfo->file($file['tmp_name']);
$allowed_mime = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

if (!in_array($mime_type, $allowed_mime)) {
    http_response_code(400);
    echo json_encode(["message" => "File không phải là ảnh hợp lệ."]);
    exit;
}

// 6. Validate kích thước (Max 2MB)
if ($file['size'] > 2 * 1024 * 1024) {
    http_response_code(400);
    echo json_encode(["message" => "File quá lớn (Max 2MB)."]);
    exit;
}

// 7. Đổi tên file ngẫu nhiên (Chống trùng lặp và đoán tên file)
$new_filename = uniqid('img_', true) . '.' . $file_ext;
$target_file = $target_dir . $new_filename;

// 8. Di chuyển file vào thư mục đích
if (move_uploaded_file($file['tmp_name'], $target_file)) {
    // Trả về URL đầy đủ để Frontend hiển thị
    // Lưu ý: Đảm bảo đường dẫn này khớp với cấu hình server của bạn
    $file_url = "http://localhost:8000/uploads/" . $sub_folder . $new_filename;

    echo json_encode([
        "status" => "success",
        "url" => $file_url,
        "filename" => $sub_folder . $new_filename
    ]);
} else {
    http_response_code(500);
    echo json_encode(["message" => "Lỗi khi lưu file vào ổ đĩa."]);
}
