<?php
if($_SERVER["REQUEST_METHOD"] != "POST"){
    http_response_code(400);
    echo "<h1>4O4 | File Not Found</h1>";
    exit;
}

// database config 
require "../../../database/config.php";
// user auth
require "../../middleware/userAuth.php";

// Set error reporting level and headers
error_reporting(0);
header("Content-type: application/json");
header("Access-Control-Allow-Origin: *");

// Retrieve the POST data as an associative array
$inputJSON = file_get_contents("php://input");
$requestData = json_decode($inputJSON, true);

// Get book category from the request data
$category = isset($requestData["category"]) ? intval($requestData["category"]) : "";
$bookname = isset($requestData["bookname"])?  $requestData["bookname"] : "";
// print_r($requestData);

// validation 
if (!is_numeric($category) || !(strlen($category) > 0 && strlen($category) <= 7)) {
    echo json_encode([]);
    exit;
};

// sql query
$sqlSearchCategory = "SELECT id, book_name FROM `books` WHERE category_id = ? AND book_name LIKE ?";
// Prepare the statement
$stmt = mysqli_prepare($conn, $sqlSearchCategory);
// Search book name
$booknamePattern = '%' . $bookname . '%';
// Bind parameters
mysqli_stmt_bind_param($stmt, "is", $category, $booknamePattern);
// Execute the query
mysqli_stmt_execute($stmt);
// Get the result
$result = mysqli_stmt_get_result($stmt);
// Fetch all rows as an associative array
$data = mysqli_fetch_all($result, MYSQLI_ASSOC);
// Convert array to JSON and output
$jsonData = json_encode($data);

echo $jsonData;
// Close the statement
mysqli_stmt_close($stmtSearchCategory);
mysqli_close($conn);

exit;
?>