<?php
// Lấy tên file hiện tại để xác định mục nào đang active
$current_page = basename($_SERVER['PHP_SELF']);
?>
<aside class="col-md-2 d-md-block sidebar collapse bg-dark">
    <div class="sidebar-sticky pt-3">
        <h5 class="text-white text-center mb-4 d-none d-md-block">Admin Panel</h5>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link <?php echo ($current_page == 'categories.php') ? 'active' : ''; ?>" href="categories.php">
                    <i class="fas fa-tags fa-icon"></i>
                    Category
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo ($current_page == 'products.php') ? 'active' : ''; ?>" href="products.php">
                    <i class="fas fa-box-open fa-icon"></i>
                    Product
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo ($current_page == 'orders.php') ? 'active' : ''; ?>" href="#">
                    <i class="fas fa-shopping-cart fa-icon"></i>
                    Order
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo ($current_page == 'customers.php') ? 'active' : ''; ?>" href="#">
                    <i class="fas fa-users fa-icon"></i>
                    Customer
                </a>
            </li>
        </ul>
    </div>
</aside>