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
$bookId = isset($requestData["bookId"]) ? $requestData["bookId"] : "";

// Validate
$bookId = intval($bookId); // Convert to integer

// Check for valid category ID
if ($bookId === 0 || strlen($bookId) > 7 || !is_int($bookId)) {
    $response = array(
        "error" => true,
        "message" => "Invalid book."
    );
    echo json_encode($response);
    exit;
}

// Delete the category from the database
$sqlDeleteBook = "DELETE FROM books WHERE id = ?";
$stmtDeleteBook = mysqli_prepare($conn, $sqlDeleteBook);
mysqli_stmt_bind_param($stmtDeleteBook, "i", $bookId);

if (mysqli_stmt_execute($stmtDeleteBook)) {
    $response = array(
        "error" => false,
        "message" => "Book deleted successfully."
    );
    echo json_encode($response);

    exit;
} else {
    $response = array(
        "error" => true,
        "message" => "Error deleting book: " . mysqli_error($conn)
    );
    echo json_encode($response);
}

// Close statement and database connection
mysqli_stmt_close($stmtDeleteCategory);
mysqli_close($conn);
?>