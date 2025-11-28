<?php
$file_path = 'maxwell_wines_products.json';
$json_string = file_get_contents($file_path);

// Kiểm tra xem có đọc file thành công không
if ($json_string === false) {
    die('Lỗi: Không thể đọc file JSON.');
}
// ... (Tiếp theo code ở Bước 1) ...

// Giải mã JSON thành MẢNG (Array) bằng cách thêm 'true'
$data_array = json_decode($json_string, true);

// Kiểm tra xem có giải mã thành công không
if (json_last_error() !== JSON_ERROR_NONE) {
    die('Lỗi: Dữ liệu JSON không hợp lệ. Lỗi: ' . json_last_error_msg());
}

// --- BÂY GIỜ BẠN CÓ THỂ SỬ DỤNG DỮ LIỆU ---

// 1. Lấy danh sách sản phẩm
$products = $data_array['products'];

// 2. Lấy thông tin metadata
$winery_name = $data_array['metadata']['winery'];
echo "<h3>Tên nhà máy rượu: $winery_name</h3>";

// 3. Lặp qua từng sản phẩm
echo "<ul>";
foreach ($products as $product) {
    // Truy cập bằng cú pháp MẢNG: $variable['key']
    $product_name = $product['name'];
    $product_price = $product['price']['regular'];
    
    echo "<li>$product_name - Giá: $$product_price AUD</li>";
}
echo "</ul>";

?>