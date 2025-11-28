<?php
// File: edit_product.php
require_once("db_connect.php"); // 1. Kết nối DB

// 2. Lấy ID từ URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // 3. Lấy thông tin sản phẩm hiện tại
    $sql_prod = "SELECT * FROM products WHERE id = $id";
    $result_prod = $conn->query($sql_prod);
    $product = $result_prod->fetch_assoc();

    // Nếu không tìm thấy sản phẩm (ví dụ ID sai), quay về trang chủ
    if (!$product) {
        header("Location: products.php");
        exit();
    }

    // 4. Lấy danh sách Categories (để nạp vào Dropdown)
    $sql_cats = "SELECT * FROM categories";
    $result_cats = $conn->query($sql_cats);
    $categories = [];
    while ($row = $result_cats->fetch_assoc()) {
        $categories[] = $row;
    }
} else {
    header("Location: products.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Edit Product</title>
    <?php include("HTML/styles.php"); ?>
</head>

<body>
    <div class="container mt-5">
        <h2>Edit Product: <?php echo $product['name']; ?></h2>

        <form action="update_product.php" method="POST">

            <input type="hidden" name="id" value="<?php echo $product['id']; ?>">

            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" class="form-control" name="name"
                    value="<?php echo $product['name']; ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Price</label>
                <input type="number" class="form-control" name="price"
                    value="<?php echo $product['price']; ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Quantity</label>
                <input type="number" class="form-control" name="qty"
                    value="<?php echo $product['qty']; ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Image URL</label>
                <input type="text" class="form-control" name="thumbnail"
                    value="<?php echo $product['thumbnail']; ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Category</label>
                <select name="category_id" class="form-select">
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?php echo $cat['id']; ?>"
                            <?php echo ($cat['id'] == $product['category_id']) ? 'selected' : ''; ?>>
                            <?php echo $cat['name']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea class="form-control" name="description" rows="3"><?php echo $product['description']; ?></textarea>
            </div>

            <button type="submit" class="btn btn-warning">Update Product</button>
            <a href="products.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>

</html>