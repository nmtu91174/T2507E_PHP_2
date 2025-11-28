<?php
// API/vnpay_create_payment.php
require_once("config.php");
require_once("../db_pdo.php");

// Cấu hình VNPay
$vnp_TmnCode = "CGXZLS0Z"; // Thay bằng mã của bạn
$vnp_HashSecret = "XNBCJFAKXVMPVARRGRCACQRMHOUFDSTJ"; // Thay bằng secret của bạn
$vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
$vnp_Returnurl = "http://localhost:5173/order-detail"; // URL frontend nhận kết quả

$input = json_decode(file_get_contents('php://input'), true);
$order_id = $input['order_id'];

// Lấy thông tin đơn hàng từ DB để đảm bảo chính xác
$stmt = $conn->prepare("SELECT total_money FROM orders WHERE id = ?");
$stmt->execute([$order_id]);
$order = $stmt->fetch();

if (!$order) {
    echo json_encode(["status" => "error", "message" => "Order not found"]);
    exit;
}

$vnp_TxnRef = $order_id; // Mã đơn hàng
$vnp_OrderInfo = "Thanh toan don hang #" . $order_id;
$vnp_OrderType = "billpayment";
$vnp_Amount = $order['total_money'] * 100; // VNPay tính bằng đồng (nhân 100)
$vnp_Locale = "vn";
$vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

$inputData = array(
    "vnp_Version" => "2.1.0",
    "vnp_TmnCode" => $vnp_TmnCode,
    "vnp_Amount" => $vnp_Amount,
    "vnp_Command" => "pay",
    "vnp_CreateDate" => date('YmdHis'),
    "vnp_CurrCode" => "VND",
    "vnp_IpAddr" => $vnp_IpAddr,
    "vnp_Locale" => $vnp_Locale,
    "vnp_OrderInfo" => $vnp_OrderInfo,
    "vnp_OrderType" => $vnp_OrderType,
    "vnp_ReturnUrl" => $vnp_Returnurl,
    "vnp_TxnRef" => $vnp_TxnRef
);

ksort($inputData);
$query = "";
$i = 0;
$hashdata = "";
foreach ($inputData as $key => $value) {
    if ($i == 1) {
        $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
    } else {
        $hashdata .= urlencode($key) . "=" . urlencode($value);
        $i = 1;
    }
    $query .= urlencode($key) . "=" . urlencode($value) . '&';
}

$vnp_Url = $vnp_Url . "?" . $query;
if (isset($vnp_HashSecret)) {
    $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);
    $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
}

echo json_encode(["status" => "success", "payment_url" => $vnp_Url]);
