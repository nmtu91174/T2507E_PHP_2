<?php
require_once("db_pdo.php");

// Lấy danh sách đơn hàng (Sắp xếp mới nhất lên đầu)
$sql = "SELECT * FROM orders ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->execute();
$orders = $stmt->fetchAll();

// Hàm hiển thị màu trạng thái cho đẹp
function getStatusBadge($status)
{
    switch ($status) {
        case 'Pending':
            return '<span class="badge bg-warning text-dark">Chờ xử lý</span>';
        case 'Processing':
            return '<span class="badge bg-info text-dark">Đang chuẩn bị</span>';
        case 'Shipping':
            return '<span class="badge bg-primary">Đang giao</span>';
        case 'Completed':
            return '<span class="badge bg-success">Hoàn thành</span>';
        case 'Cancelled':
            return '<span class="badge bg-danger">Đã hủy</span>';
        default:
            return '<span class="badge bg-secondary">' . $status . '</span>';
    }
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <title>Quản lý Đơn hàng</title>
    <?php include("HTML/styles.php"); ?>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <?php include("HTML/aside.php"); ?>

            <main class="col-md-10 ms-sm-auto px-md-4 main-content">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Danh sách Đơn hàng</h1>
                </div>

                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Mã đơn (#)</th>
                                        <th>Khách hàng</th>
                                        <th>Ngày đặt</th>
                                        <th>Tổng tiền</th>
                                        <th>Thanh toán</th>
                                        <th>Trạng thái</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($orders as $order): ?>
                                        <tr>
                                            <td><strong>#<?php echo $order['id']; ?></strong></td>
                                            <td>
                                                <?php echo htmlspecialchars($order['customer_name']); ?><br>
                                                <small class="text-muted"><?php echo htmlspecialchars($order['customer_phone']); ?></small>
                                            </td>
                                            <td><?php echo date('d/m/Y H:i', strtotime($order['created_at'])); ?></td>
                                            <td class="text-danger fw-bold">
                                                <?php echo number_format($order['total_money']); ?> đ
                                            </td>
                                            <td>
                                                <span class="badge bg-light text-dark border border-secondary">
                                                    <?php echo $order['payment_method']; ?>
                                                </span>
                                            </td>
                                            <td><?php echo getStatusBadge($order['status']); ?></td>
                                            <td>
                                                <a href="order_detail.php?id=<?php echo $order['id']; ?>" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-eye"></i> Xem
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>