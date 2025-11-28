<?php
session_start();

// Xóa tất cả các biến trong session
$_SESSION = array();

// Hủy hoàn toàn phiên làm việc
session_destroy();

// Chuyển hướng về trang login
header("Location: login.php");
exit();
