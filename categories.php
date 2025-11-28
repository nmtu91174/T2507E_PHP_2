<?php
// Kết nối Database
$host = "localhost";
$user = "root";
$pwd = "root";
$db = "t2507e_db";

$conn = new mysqli($host, $user, $pwd, $db);
if ($conn->connect_error) {
    die("Connect database fail! " . $conn->connect_error);
}

// Query data
$sql = "select * from categories";
$rs = $conn->query($sql);

$data = [];
if ($rs && $rs->num_rows > 0) {
    while ($row = $rs->fetch_assoc()) {
        $data[] = $row;
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories Dashboard</title>
    <?php include("HTML/styles.php"); ?>
</head>

<body>

    <div class="container-fluid">
        <div class="row">
            <?php include("HTML/aside.php"); ?>

            <main class="col-md-10 ms-sm-auto px-md-4 main-content">

                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Manage Categories</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <a href="create_category.php" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus me-1"></i> Create Category
                        </a>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col" style="width: 50px;">#ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Slug</th>
                                <th scope="col" style="width: 150px;" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($data) == 0): ?>
                                <tr>
                                    <td colspan="4" class="text-center text-muted">No categories found.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($data as $item): ?>
                                    <tr>
                                        <th scope="row"><?php echo htmlspecialchars($item["id"]); ?></th>
                                        <td><?php echo htmlspecialchars($item["name"]); ?></td>
                                        <td><?php echo htmlspecialchars($item["slug"]); ?></td>
                                        <td class="text-center">
                                            <a href="edit_category.php?id=<?php echo $item['id']; ?>" class="btn btn-sm btn-outline-info"><i class="fas fa-edit"></i></a>
                                            <a href="delete_category.php?id=<?php echo $item['id']; ?>"
                                                class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này không? Hành động này không thể hoàn tác!');">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>