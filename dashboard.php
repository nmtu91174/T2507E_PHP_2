<?php
require_once("db_pdo.php");

// 1. Tổng doanh thu (Chỉ tính đơn Completed)
$stmtRevenue = $conn->query("SELECT SUM(total_money) as revenue FROM orders WHERE status = 'Completed'");
$revenue = $stmtRevenue->fetch()['revenue'] ?? 0;

// 2. Số lượng đơn hàng mới (Pending)
$stmtNewOrders = $conn->query("SELECT COUNT(*) as count FROM orders WHERE status = 'Pending'");
$newOrders = $stmtNewOrders->fetch()['count'];

// 3. Sản phẩm sắp hết hàng (Qty < 10)
$stmtLowStock = $conn->query("SELECT * FROM products WHERE qty < 10 ORDER BY qty ASC LIMIT 5");
$lowStocks = $stmtLowStock->fetchAll();

// 4. Top sản phẩm bán chạy
$stmtTop = $conn->query("
    SELECT p.name, SUM(od.quantity) as total_sold 
    FROM order_details od
    JOIN products p ON od.product_id = p.id
    JOIN orders o ON od.order_id = o.id
    WHERE o.status = 'Completed'
    GROUP BY p.id
    ORDER BY total_sold DESC
    LIMIT 5
");
$topProducts = $stmtTop->fetchAll();
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <title>Admin Dashboard</title>
    <?php include("HTML/styles.php"); ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <?php include("HTML/aside.php"); ?>

            <main class="col-md-10 ms-sm-auto px-md-4 main-content">
                <h1 class="h2 pt-3 pb-2 mb-3 border-bottom">Dashboard</h1>

                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="card text-white bg-success mb-3 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">Doanh thu</h5>
                                <p class="card-text fs-3 fw-bold"><?php echo number_format($revenue); ?> đ</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-white bg-warning mb-3 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">Đơn hàng mới</h5>
                                <p class="card-text fs-3 fw-bold"><?php echo $newOrders; ?> đơn</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-white bg-danger mb-3 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">Cảnh báo kho</h5>
                                <p class="card-text fs-3 fw-bold"><?php echo count($lowStocks); ?> sản phẩm</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="card shadow-sm h-100">
                            <div class="card-header bg-danger text-white">
                                <i class="fas fa-exclamation-triangle"></i> Sản phẩm sắp hết hàng
                            </div>
                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    <?php foreach ($lowStocks as $p): ?>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <?php echo htmlspecialchars($p['name']); ?>
                                            <span class="badge bg-danger rounded-pill">Còn: <?php echo $p['qty']; ?></span>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card shadow-sm h-100">
                            <div class="card-header">Top sản phẩm bán chạy</div>
                            <div class="card-body">
                                <canvas id="topProductChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Vẽ biểu đồ đơn giản
        const ctx = document.getElementById('topProductChart').getContext('2d');
        const labels = <?php echo json_encode(array_column($topProducts, 'name')); ?>;
        const data = <?php echo json_encode(array_column($topProducts, 'total_sold')); ?>;

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Số lượng đã bán',
                    data: data,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)'
                }]
            }
        });
    </script>
</body>

</html>