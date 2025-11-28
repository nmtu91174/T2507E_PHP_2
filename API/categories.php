<?php
require_once("config.php");
// Lấy tất cả danh mục
$sql = "SELECT * FROM categories";
$result = $conn->query($sql);
$data = $result->fetch_all(MYSQLI_ASSOC);
echo json_encode($data);
$conn->close();
?>