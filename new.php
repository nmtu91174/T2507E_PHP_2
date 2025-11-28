<?php
// các thông số
$host = 'localhost';
$user = 'root';
$pwd = 'root';
$db = 't2507e';

//B1 kết nối db

$conn = new mysqli($host, $user, $pwd, $db); 
if ($conn->connect_error) {
    die("Connect database fail!" . $conn->connect_error);
}

//B2 truy vấn dữ liệu QUERY DATA

$SQL = "SELECT * FROM categories";
$result = $conn->query($SQL);

//B3 hiển thị dữ liệu DISPLAY DATA get data
$data = [];
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) // fetch_assoc() trả về mảng kết hợp 
    {
        echo "id: " . $row["id"]. " - Name: " . $row["name"]. " " . $row["slug"]. "<br>";

        $data[] = $row;
    }
} else {
    echo "0 results";
}
var_dump($data);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h3>Danh sách categories</h3>
    <ul>
        <?php foreach($data as $item): ?>
            <li>
                <?php echo $item['name']; ?> - <?php echo $item['slug']; ?>
            </li>
        <?php endforeach; ?>
    </ul>
    
</body>
</html>