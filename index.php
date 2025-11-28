<?php
// code php here
echo "Hello, World!";
//variable - data types

$x;
$x = 10; //number
$x = "hello"; //string
$x = 10.5; //float  

echo $x;

// $y = 20;
// if ($y > 10) {
//     echo "y is greater than 10";
// } elseif {$y
//     echo "y is less than or equal to 10";
// } else {
//     echo "y is equal to 10";
// }       

for($i = 0; $i < 5; $i++) {
    echo "vòng lặp thứ: $i";
    echo "<br>";
    echo $i;
}

// $arr = [];
// $arr[] = "apple";
// $arr[] = "banana";      
// $arr[] = true;
// print_r($arr);

$student = [];
$student['name'] = "John";
$student['age'] = 20;
echo "<br>";
echo $student['name']." is ".$student['age']." years old.";
echo "<br>";
print_r($student);

$products = [
    [
        'name' => 'Laptop',
        'price' => 1000,
        'quantity' => 5
    ],
    [
        'name' => 'Phone',
        'price' => 500,
        'quantity' => 10
    ]
];
echo "<br>";
echo $products[0]['name']." costs ".$products[0]['price'];
echo "<br>";
print_r($products[0]);  

foreach($arr as $item) {
    echo "<br>";
    echo $item; //arr[0], arr[1], arr[2]
}

foreach($products as $product) {
    echo "<br>";
    echo $product['name']." - ".$product['price']." - ".$product['quantity'];
}

foreach($products as $key=>$product) {
    echo "<br>";
    echo $key." - ".$product['name']." - ".$product['price']." - ".$product['quantity'];
}

function total($a,$b){
    echo $a + $b;
}
echo "<br>";
echo "a+b = ";
total(10,20);


?>
