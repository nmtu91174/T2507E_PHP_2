<?php
// File: API/products.php
require_once("config.php");
require_once("../db_pdo.php");

// Chỉ nhận GET
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405); exit;
}

try {
    // 1. Lấy chi tiết 1 sản phẩm
    if (isset($_GET['id'])) {
        $stmt = $conn->prepare("SELECT p.*, c.name as category_name FROM products p 
                                LEFT JOIN categories c ON p.category_id = c.id 
                                WHERE p.id = ?");
        $stmt->execute([$_GET['id']]);
        $product = $stmt->fetch();
        echo json_encode($product ?: ["message" => "Not found"]);
        exit;
    }

    // 2. Xây dựng câu Query lọc danh sách (Search & Filter)
    $sql = "SELECT * FROM products WHERE 1=1";
    $params = [];

    // Lọc theo danh mục
    if (isset($_GET['category_id']) && $_GET['category_id'] !== '') {
        $sql .= " AND category_id = ?";
        $params[] = $_GET['category_id'];
    }

    // Tìm kiếm theo tên
    if (isset($_GET['search']) && $_GET['search'] !== '') {
        $sql .= " AND name LIKE ?";
        $params[] = "%" . $_GET['search'] . "%";
    }

    // Lọc theo khoảng giá
    if (isset($_GET['min_price'])) {
        $sql .= " AND price >= ?";
        $params[] = $_GET['min_price'];
    }
    if (isset($_GET['max_price'])) {
        $sql .= " AND price <= ?";
        $params[] = $_GET['max_price'];
    }

    // Sắp xếp (Sort)
    $sort = $_GET['sort'] ?? 'newest';
    switch ($sort) {
        case 'price_asc': $sql .= " ORDER BY price ASC"; break;
        case 'price_desc': $sql .= " ORDER BY price DESC"; break;
        default: $sql .= " ORDER BY id DESC"; // Mặc định mới nhất
    }

    // Phân trang (Pagination)
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 12; // Mặc định 12 sản phẩm/trang
    $offset = ($page - 1) * $limit;

    // Query tổng số lượng (để tính số trang)
    $stmtCount = $conn->prepare(str_replace("SELECT *", "SELECT COUNT(*) as total", $sql));
    $stmtCount->execute($params);
    $totalRecords = $stmtCount->fetch()['total'];
    $totalPages = ceil($totalRecords / $limit);

    // Query lấy dữ liệu chính thức
    $sql .= " LIMIT $limit OFFSET $offset";
    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    $products = $stmt->fetchAll();

    // Trả về JSON kèm thông tin phân trang
    echo json_encode([
        "data" => $products,
        "pagination" => [
            "current_page" => $page,
            "total_pages" => $totalPages,
            "total_records" => $totalRecords
        ]
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
?>