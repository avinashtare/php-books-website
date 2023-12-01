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

// Get category ID from the request data
$book_category_id = isset($requestData["category"]) ? $requestData["category"] : "";

// Validate
$book_category_id = intval($book_category_id); // Convert to integer

// Check for valid category ID
if ($book_category_id === 0 || strlen($book_category_id) > 7 || !is_int($book_category_id)) {
    $response = array(
        "error" => true,
        "message" => "Invalid category."
    );
    echo json_encode($response);
    exit;
}

// Delete all related books
$sqlDeleteBooks = "DELETE FROM books WHERE category_id = ?";
$stmtDeleteBooks = mysqli_prepare($conn, $sqlDeleteBooks);
mysqli_stmt_bind_param($stmtDeleteBooks, "i", $book_category_id);

if (!mysqli_stmt_execute($stmtDeleteBooks)) {
    $response = array(
        "error" => true,
        "message" => "Failed To Delete Category."
    );
    echo json_encode($response);
    exit;
}

// Delete the category from the database
$sqlDeleteCategory = "DELETE FROM book_category WHERE id = ?";
$stmtDeleteCategory = mysqli_prepare($conn, $sqlDeleteCategory);
mysqli_stmt_bind_param($stmtDeleteCategory, "i", $book_category_id);

if (mysqli_stmt_execute($stmtDeleteCategory)) {
    $response = array(
        "error" => false,
        "message" => "Category deleted successfully."
    );
    echo json_encode($response);

    exit;
} else {
    $response = array(
        "error" => true,
        "message" => "Error deleting category: " . mysqli_error($conn)
    );
    echo json_encode($response);
}

// Close statement and database connection
mysqli_stmt_close($stmtDeleteCategory);
mysqli_close($conn);
?>