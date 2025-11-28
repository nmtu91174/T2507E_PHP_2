<?php
// API/config.php

// Chỉ cho phép Frontend của bạn gọi API (Ví dụ frontend chạy ở port 5173)
// Khi deploy, hãy đổi thành domain thật (ví dụ: https://my-shop.com)
header("Access-Control-Allow-Origin: http://localhost:5173"); 

header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Credentials: true"); // Cho phép gửi cookie/session

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Lưu ý: Các file API khác sẽ include file này, nên không cần include db_connect cũ ở đây nữa
?>