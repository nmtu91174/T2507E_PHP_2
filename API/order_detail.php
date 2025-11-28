<?php
require_once("config.php");

if (isset($_GET['id'])) {
    $order_id = intval($_GET['id']);

    // 1. Lấy thông tin chung đơn hàng
    $sql_order = "SELECT * FROM orders WHERE id = $order_id";
    $order = $conn->query($sql_order)->fetch_assoc();

    if ($order) {
        // 2. Lấy danh sách sản phẩm trong đơn
        $sql_items = "SELECT od.*, p.name, p.thumbnail 
                      FROM order_details od 
                      JOIN products p ON od.product_id = p.id 
                      WHERE od.order_id = $order_id";
        $items = $conn->query($sql_items)->fetch_all(MYSQLI_ASSOC);

        $order['items'] = $items;
        echo json_encode($order);
    } else {
        http_response_code(404);
        echo json_encode(["message" => "Order not found"]);
    }
}
$conn->close();
?>