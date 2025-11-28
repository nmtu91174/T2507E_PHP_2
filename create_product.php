<?php
require_once("db_connect.php");

// A. LẤY DANH SÁCH CATEGORY ĐỂ HIỂN THỊ TRONG DROPDOWN
$sql_cats = "SELECT * FROM categories";
$result_cats = $conn->query($sql_cats);
$categories = [];
if ($result_cats->num_rows > 0) {
    while($row = $result_cats->fetch_assoc()) {
        $categories[] = $row;
    }
}

// B. XỬ LÝ KHI NGƯỜI DÙNG BẤM LƯU
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $price = $_POST["price"];
    $qty = $_POST["qty"];
    $thumbnail = $_POST["thumbnail"];
    $description = $_POST["description"];
    $category_id = $_POST["category_id"];

    // Validate
    if (!empty($name) && !empty($price)) {
        // Escape dữ liệu
        $name = $conn->real_escape_string($name);
        $thumbnail = $conn->real_escape_string($thumbnail);
        $description = $conn->real_escape_string($description);
        // Ép kiểu số an toàn
        $price = (float)$price;
        $qty = (int)$qty;
        $category_id = (int)$category_id;

        $sql = "INSERT INTO products (name, price, qty, thumbnail, description, category_id) 
                VALUES ('$name', $price, $qty, '$thumbnail', '$description', $category_id)";

        if ($conn->query($sql) === TRUE) {
            header("Location: products.php");
            exit();
        } else {
            $error_msg = "Error: " . $conn->error;
        }
    } else {
        $error_msg = "Tên và Giá là bắt buộc!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Product</title>
    <?php include("HTML/styles.php"); ?>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <?php include("HTML/aside.php"); ?>

            <main class="col-md-10 ms-sm-auto px-md-4 main-content">
                <div class="pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Create New Product</h1>
                </div>

                <?php if(isset($error_msg)): ?>
                    <div class="alert alert-danger"><?php echo $error_msg; ?></div>
                <?php endif; ?>

                <div class="card shadow-sm mb-5">
                    <div class="card-body">
                        <form action="create_product.php" method="POST">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Product Name (*)</label>
                                        <input type="text" name="name" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Price ($) (*)</label>
                                        <input type="number" name="price" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Quantity</label>
                                        <input type="number" name="qty" class="form-control" value="1">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Category</label>
                                        <select name="category_id" class="form-select">
                                            <option value="">-- Select Category --</option>
                                            <?php foreach($categories as $cat): ?>
                                                <option value="<?php echo $cat['id']; ?>">
                                                    <?php echo $cat['name']; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Image URL</label>
                                        <input type="text" name="thumbnail" class="form-control" placeholder="https://...">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="3"></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">Create Product</button>
                            <a href="products.php" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>