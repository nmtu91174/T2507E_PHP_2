<?php
// Dữ liệu sản phẩm của bạn
$products = [
    [
        'id' => 1, // Thêm ID để sau này làm link
        'name' => 'Laptop',
        'price' => 1000,
        'quantity' => 5,
        'image_url' => 'https://laptoptitan.vn/wp-content/uploads/2021/04/15-Laptop-Tot-nhat-2021-1.jpg' // Thêm ảnh minh họa
    ],
    [
        'id' => 2,
        'name' => 'Phone',
        'price' => 500,
        'quantity' => 10,
        'image_url' => './images/iphone.webp' // Thêm ảnh minh họa
    ],
    [
        'id' => 3,
        'name' => 'Headphones',
        'price' => 150,
        'quantity' => 20,
        'image_url' => './images/headphones.webp' // Thêm ảnh minh họa
    ]
];
?>
    <!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách Sản phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
       
</head>
<body>

    <div class="container mt-5">
        
        <h1 class="mb-4 text-center">Sản phẩm của chúng tôi</h1>
        
        <div class="row">

            <?php
            // Bắt đầu vòng lặp PHP
         foreach ($products as $product):
            ?>

            <div class="col-lg-4 col-md-6 mb-4">
                
                <div class="card h-100">
                    <img src="<?php echo htmlspecialchars($product['image_url']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($product['name']); ?>">
                    
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">
                            <?php echo htmlspecialchars($product['name']); ?>
                        </h5>
                        
                        <h6 class="card-subtitle mb-2 text-danger">
                            $<?php echo number_format($product['price']); ?>
                        </h6>
                        
                        <p class="card-text">
                            Số lượng còn lại: <?php echo htmlspecialchars($product['quantity']); ?>
                        </p>
                        
                        <a href="product-detail.php?id=<?php echo $product['id']; ?>" class="btn btn-primary mt-auto">
                            Xem chi tiết
                        </a>
                    </div>
                </div>
                
            </div> <?php
            // Kết thúc vòng lặp PHP
            endforeach;
            ?>

        </div>
     </div>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>