<?php
// 1. Kết nối Database
require_once("db_connect.php");

// 2. Kiểm tra tham số ID trên URL (Logic cho phương thức GET)
// Ví dụ: edit_category.php?id=5 -> Lấy số 5
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Ép kiểu thành số nguyên để bảo mật

    // Lấy thông tin danh mục hiện tại từ Database
    $sql_get = "SELECT * FROM categories WHERE id = $id";
    $result = $conn->query($sql_get);

    if ($result->num_rows > 0) {
        $category = $result->fetch_assoc(); // Lấy dữ liệu bỏ vào biến $category
    } else {
        // Nếu không tìm thấy ID này -> Quay về trang danh sách
        header("Location: categories.php");
        exit();
    }
} else {
    // Nếu không có ID trên URL -> Quay về trang danh sách
    header("Location: categories.php");
    exit();
}

// 3. Xử lý khi người dùng bấm nút Update (Logic cho phương thức POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $slug = $_POST["slug"];
    
    // Validation: Kiểm tra rỗng
    if (!empty($name) && !empty($slug)) {
        // Sanitization: Làm sạch dữ liệu
        $name = $conn->real_escape_string($name);
        $slug = $conn->real_escape_string($slug);

        // Câu lệnh UPDATE
        // CỰC KỲ QUAN TRỌNG: Phải có WHERE id = ...
        $sql_update = "UPDATE categories SET name = '$name', slug = '$slug' WHERE id = $id";

        if ($conn->query($sql_update) === TRUE) {
            header("Location: categories.php"); // Thành công -> Về danh sách
            exit();
        } else {
            $error_msg = "Lỗi: " . $conn->error;
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
    <title>Edit Category</title>
    <?php include("HTML/styles.php"); ?>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <?php include("HTML/aside.php"); ?>

            <main class="col-md-10 ms-sm-auto px-md-4 main-content">
                <div class="pt-3 pb-2 mb-3 border-bottom">
                    <!-- <h1 class="h2">Edit Category: #<?php echo $category['id']; ?></h1> -->
                    <h1 class="h2">Edit Category</h1>
                </div>

                <?php if(isset($error_msg)): ?>
                    <div class="alert alert-danger"><?php echo $error_msg; ?></div>
                <?php endif; ?>

                <div class="card shadow-sm">
                    <div class="card-body">
                        <form action="" method="POST">

                        <div class="mb-3">
                                <!-- <label class="form-label">Category id</label> -->
                                <input type="hidden" class="form-control" name="name" 
                                       value="<?php echo $category['id']; ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Category Name</label>
                                <input type="text" class="form-control" name="name" 
                                       value="<?php echo $category['name']; ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Slug</label>
                                <input type="text" class="form-control" name="slug" 
                                       value="<?php echo $category['slug']; ?>" required>
                            </div>

                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save me-1"></i> Update
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