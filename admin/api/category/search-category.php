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
$category = isset($requestData["category"]) ? $requestData["category"] : "";

// Prepare the search query
$sqlSearchCategory = "SELECT id,category FROM `book_category` WHERE category LIKE ? LIMIT 7";
$stmtSearchCategory = mysqli_prepare($conn, $sqlSearchCategory);
$searchTerm = '%' . $category . '%';
mysqli_stmt_bind_param($stmtSearchCategory, "s", $searchTerm);
mysqli_stmt_execute($stmtSearchCategory);
$result = mysqli_stmt_get_result($stmtSearchCategory);

// Fetch all rows as an associative array
$data = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Close the statement
mysqli_stmt_close($stmtSearchCategory);
mysqli_close($conn);

// Return the response as JSON
echo json_encode($data);
exit;
?>