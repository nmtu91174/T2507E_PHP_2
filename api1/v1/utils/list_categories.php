<?php
require_once("utils/db.php");
require_once("utils/helper.php");

$sql = "SELECT * FROM categories;";
$data = query($sql);

// var_dump($data);
// echo json_encode($data);
if ($data !== null) {
    sendJsonResponse($data);
} else {
    sendJsonResponse(["message" => "No categories found."], 404);
}
