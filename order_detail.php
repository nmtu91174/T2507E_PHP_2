<?php
require_once("db_pdo.php");

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Xử lý cập nhật trạng thái
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['status'])) {
    $new_status = $_POST['status'];
    $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $stmt->execute([$new_status, $id]);

    // Refresh trang để thấy thay đổi
    header("Location: order_detail.php?id=$id&msg=updated");
    exit;
}

// Lấy thông tin đơn hàng
$stmt = $conn->prepare("SELECT * FROM orders WHERE id = ?");
$stmt->execute([$id]);
$order = $stmt->fetch();

if (!$order) die("Đơn hàng không tồn tại");

// Lấy chi tiết sản phẩm
$stmtItems = $conn->prepare("
    SELECT od.*, p.name, p.thumbnail 
    FROM order_details od
    JOIN products p ON od.product_id = p.id
    WHERE od.order_id = ?
");
$stmtItems->execute([$id]);
$items = $stmtItems->fetchAll();
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <title>Chi tiết Đơn hàng #<?php echo $id; ?></title>
    <?php include("HTML/styles.php"); ?>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <?php include("HTML/aside.php"); ?>

            <main class="col-md-10 ms-sm-auto px-md-4 main-content">
                <div class="pt-3 pb-2 mb-3 border-bottom d-flex justify-content-between">
                    <h1 class="h2">Đơn hàng #<?php echo $id; ?></h1>
                    <a href="orders.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Quay lại</a>
                </div>

                <?php if (isset($_GET['msg'])): ?>
                    <div class="alert alert-success">Cập nhật trạng thái thành công!</div>
                <?php endif; ?>

                <div class="row">
                    <div class="col-md-4">
                        <div class="card mb-3 shadow-sm">
                            <div class="card-header bg-primary text-white">Thông tin khách hàng</div>
                            <div class="card-body">
                                <p><strong>Họ tên:</strong> <?php echo htmlspecialchars($order['customer_name']); ?></p>
                                <p><strong>Email:</strong> <?php echo htmlspecialchars($order['customer_email']); ?></p>
                                <p><strong>SĐT:</strong> <?php echo htmlspecialchars($order['customer_phone']); ?></p>
                                <p><strong>Địa chỉ:</strong> <?php echo htmlspecialchars($order['customer_address']); ?></p>
                            </div>
                        </div>

                        <div class="card shadow-sm">
                            <div class="card-header bg-warning text-dark">Cập nhật Trạng thái</div>
                            <div class="card-body">
                                <form method="POST">
                                    <div class="mb-3">
                                        <label class="form-label">Trạng thái hiện tại:</label>
                                        <select name="status" class="form-select">
                                            <?php
                                            $statuses = ['Pending', 'Processing', 'Shipping', 'Completed', 'Cancelled'];
                                            foreach ($statuses as $st) {
                                                $selected = ($order['status'] == $st) ? 'selected' : '';
                                                echo "<option value='$st' $selected>$st</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-success w-100">Cập nhật</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="card shadow-sm">
                            <div class="card-header">Chi tiết sản phẩm</div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Sản phẩm</th>
                                            <th>Giá</th>
                                            <th>SL</th>
                                            <th>Thành tiền</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($items as $item): ?>
                                            <tr>
                                                <td class="d-flex align-items-center">
                                                    <img src="<?php echo htmlspecialchars($item['thumbnail']); ?>" width="50" class="me-2 rounded">
                                                    <?php echo htmlspecialchars($item['name']); ?>
                                                </td>
                                                <td><?php echo number_format($item['price']); ?></td>
                                                <td><?php echo $item['quantity']; ?></td>
                                                <td><?php echo number_format($item['price'] * $item['quantity']); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                        <tr>
                                            <td colspan="3" class="text-end fw-bold">Phí vận chuyển:</td>
                                            <td><?php echo number_format($order['shipping_fee']); ?></td>
                                        </tr>
                                        <tr class="table-active">
                                            <td colspan="3" class="text-end fw-bold text-danger">TỔNG CỘNG:</td>
                                            <td class="fw-bold text-danger"><?php echo number_format($order['total_money']); ?> đ</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>