<?php

$lists = [
    [
        'id' => 1,
        'name' => 'Sản phẩm A',
        'price' => 1500,
        'quantity' => 3,
        'image_url' => 'images/product_a.jpg'
    ],
    [
        'id' => 2,
        'name' => 'Sản phẩm B',
        'price' => 2500,
        'quantity' => 7,
        'image_url' => 'images/product_b.jpg'
    ],
    [
        'id' => 3,
        'name' => 'Sản phẩm C',
        'price' => 3500,
        'quantity' => 2,
        'image_url' => 'images/product_c.jpg'
    ],
    [
        'id' => 4,
        'name' => 'Sản phẩm D',
        'price' => 4500,
        'quantity' => 5,
        'image_url' => 'images/product_d.jpg'
    ],
    [
        'id' => 5,
        'name' => 'Sản phẩm E',
        'price' => 5500,
        'quantity' => 4,
        'image_url' => 'images/product_e.jpg'
    ],
    [
        'id' => 6,
        'name' => 'Sản phẩm F',
        'price' => 6500,
        'quantity' => 6,
        'image_url' => 'images/product_f.jpg'
    ]
];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4 text-center">Danh sách Sản phẩm</h1>
        <div class="row">
            <?php foreach ($lists as $item): ?>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card h-100">
                        <img src="<?php echo htmlspecialchars($item['image_url']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($item['name']); ?>">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">
                                <?php echo htmlspecialchars($item['name']); ?>  
                            </h5>
                            <h6 class="card-subtitle mb-2 text-danger"> 
                                $<?php echo number_format($item['price']); ?>
                            </h6>
                            <p class="card-text">       
                                Số lượng còn lại: <?php echo htmlspecialchars($item['quantity']); ?>
                            </p>
                            <a href="detail.php?id=<?php echo $item['id']; ?>" class="
btn btn-primary mt-auto">
                                Xem chi tiết            
                            </a>
                        </div>  
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

                
</body>
</html>