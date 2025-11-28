<?php
$host = "localhost";
$user = "root";
$pwd = "root";
$db = "t2507e_db";

$conn = new mysqli($host, $user, $pwd, $db);
if ($conn->connect_error) {
    die("Connect database fail!");
}

// Join bảng products và categories để lấy tên danh mục
$sql = "SELECT products.*, categories.name as category_name 
            FROM products 
            LEFT JOIN categories ON products.category_id = categories.id";

$rs = $conn->query($sql);
$data = [];
if ($rs && $rs->num_rows > 0) {
    while ($row = $rs->fetch_assoc()) {
        $data[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management</title>
    <?php include("HTML/styles.php"); ?>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <?php include("HTML/aside.php"); ?>

            <main class="col-md-10 ms-sm-auto px-md-4 main-content">

                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Product List</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <a href="create_product.php" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus me-1"></i> Create Product
                        </a>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">#ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Image</th>
                                <th scope="col">Price</th>
                                <th scope="col">Qty</th>
                                <th scope="col">Category</th>
                                <th scope="col" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data as $item): ?>
                                <tr>
                                    <th scope="row"><?php echo $item["id"]; ?></th>
                                    <td><strong><?php echo htmlspecialchars($item["name"]); ?></strong></td>
                                    <td>
                                        <img src="<?php echo htmlspecialchars($item["thumbnail"]); ?>" class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;" alt="Product Img" />
                                    </td>
                                    <td class="text-success fw-bold">$<?php echo number_format($item["price"]); ?></td>
                                    <td><?php echo $item["qty"]; ?></td>
                                    <td>
                                        <span class="badge bg-secondary">
                                            <?php echo htmlspecialchars($item["category_name"] ?? 'No Category'); ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="edit_product.php?id=<?php echo $item['id']; ?>" class="btn btn-sm btn-outline-info"><i class="fas fa-edit"></i></a>
                                        <a href="delete_product.php?id=<?php echo $item['id']; ?>" class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này không? Hành động này không thể hoàn tác!');">
                                            <i class="fas fa-trash-alt"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>