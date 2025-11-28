<?php
// File: API/checkout.php
require_once("config.php");
require_once("../db_pdo.php");
/** @var PDO $conn */  // <--- Thêm dòng này vào để báo cho VS Code biết $conn là gì
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

if (!$input || empty($input['cart'])) {
    http_response_code(400);
    echo json_encode(["message" => "Dữ liệu không hợp lệ"]);
    exit;
}

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

try {
    $conn->beginTransaction();

    $product_total = 0; // Tổng tiền hàng
    $cart_items_validated = [];

    $stmtProduct = $conn->prepare("SELECT price FROM products WHERE id = ?");

    // 1. Tính tiền hàng
    foreach ($input['cart'] as $item) {
        $id = intval($item['id']);
        $qty = intval($item['qty']);
        if ($qty <= 0) continue;

        $stmtProduct->execute([$id]);
        $productDB = $stmtProduct->fetch();
        if (!$productDB) throw new Exception("Sản phẩm ID $id không tồn tại.");

        $price = floatval($productDB['price']);
        $product_total += $price * $qty;

        $cart_items_validated[] = ['id' => $id, 'price' => $price, 'qty' => $qty];
    }

    // 2. Tính phí Ship & Tổng thanh toán
    $shipping_fee = ($product_total >= 1000000) ? 0 : 30000;
    $final_total = $product_total + $shipping_fee;

    // Nhận phương thức thanh toán từ Client (mặc định COD)
    $payment_method = isset($input['payment_method']) ? $input['payment_method'] : 'COD';

    // 3. Tạo Đơn hàng
    $sqlOrder = "INSERT INTO orders (user_id, customer_name, customer_email, customer_phone, customer_address, total_money, shipping_fee, payment_method, payment_status) 
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, 0)"; // 0 = Chưa thanh toán
    $stmtOrder = $conn->prepare($sqlOrder);

    // Sanitize
    $name = htmlspecialchars(strip_tags($input['customer_name']));
    $email = filter_var($input['customer_email'], FILTER_SANITIZE_EMAIL);
    $phone = htmlspecialchars(strip_tags($input['customer_phone']));
    $addr = htmlspecialchars(strip_tags($input['customer_address']));

    $stmtOrder->execute([$user_id, $name, $email, $phone, $addr, $final_total, $shipping_fee, $payment_method]);
    $order_id = $conn->lastInsertId();

    // 4. Tạo chi tiết đơn hàng & TRỪ TỒN KHO
    $sqlDetail = "INSERT INTO order_details (order_id, product_id, price, quantity) VALUES (?, ?, ?, ?)";
    $stmtDetail = $conn->prepare($sqlDetail);

    // Chuẩn bị câu lệnh trừ kho
    $sqlUpdateQty = "UPDATE products SET qty = qty - ? WHERE id = ? AND qty >= ?";
    $stmtUpdateQty = $conn->prepare($sqlUpdateQty);

    foreach ($cart_items_validated as $item) {
        // Insert chi tiết đơn hàng
        $stmtDetail->execute([$order_id, $item['id'], $item['price'], $item['qty']]);

        // Trừ tồn kho
        $stmtUpdateQty->execute([$item['qty'], $item['id'], $item['qty']]);

        // Kiểm tra xem có trừ được không (nếu kho không đủ thì query update sẽ không chạy do điều kiện qty >= ?)
        if ($stmtUpdateQty->rowCount() === 0) {
            throw new Exception("Sản phẩm ID " . $item['id'] . " không đủ hàng trong kho.");
        }
    }

    $conn->commit();

    echo json_encode([
        "status" => "success",
        "order_id" => $order_id,
        "total" => $final_total,
        "payment_method" => $payment_method
    ]);
} catch (Exception $e) {
    if ($conn->inTransaction()) $conn->rollBack();
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
