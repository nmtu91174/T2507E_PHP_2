<?php
// 1. Nhúng file kết nối
require_once("db_connect.php");

// 2. Kiểm tra xem người dùng có submit form không
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $name = $_POST["name"];
    $slug = $_POST["slug"];

    // Validate cơ bản: Không được để trống
    if (!empty($name) && !empty($slug)) {
        // Xử lý ký tự đặc biệt để tránh lỗi SQL (SQL Injection)
        $name = $conn->real_escape_string($name);
        $slug = $conn->real_escape_string($slug);

        // Câu lệnh SQL chèn dữ liệu
        $sql = "INSERT INTO categories (name, slug) VALUES ('$name', '$slug')";

        if ($conn->query($sql) === TRUE) {
            // Thành công -> Chuyển hướng về trang danh sách
            header("Location: categories.php");
            exit();
        } else {
            $error_msg = "Lỗi SQL: " . $conn->error;
        }
    } else {
        $error_msg = "Vui lòng nhập đầy đủ thông tin!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Category</title>
    <?php include("HTML/styles.php"); ?>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <?php include("HTML/aside.php"); ?>

            <main class="col-md-10 ms-sm-auto px-md-4 main-content">
                <div class="pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Create New Category</h1>
                </div>

                <?php if(isset($error_msg)): ?>
                    <div class="alert alert-danger"><?php echo $error_msg; ?></div>
                <?php endif; ?>

                <div class="card shadow-sm">
                    <div class="card-body">
                        <form action="create_category.php" method="POST">
                            
                            <div class="mb-3">
                                <label for="name" class="form-label">Category Name</label>
                                <input type="text" class="form-control" id="name" name="name" required placeholder="Ví dụ: Điện thoại">
                            </div>

                            <div class="mb-3">
                                <label for="slug" class="form-label">Slug (URL Friendly)</label>
                                <input type="text" class="form-control" id="slug" name="slug" required placeholder="Ví dụ: dien-thoai">
                            </div>

                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Save Category
                            </button>
                            <a href="categories.php" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>