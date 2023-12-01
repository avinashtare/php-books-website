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

// Get book title and category from the request data
$book_title = isset($requestData["title"]) ? $requestData["title"] : "";
$book_category = isset($requestData["category"]) ? $requestData["category"] : "";

// Validate and sanitize book title and category
$book_title = substr($book_title, 0, 30); // Limit title to 30 characters
$book_category = substr($book_category, 0, 50); // Limit category to 50 characters

// Check for length validation
if (strlen($book_title) < 1 || strlen($book_title) > 30 || strlen($book_category) < 1 || strlen($book_category) > 50) {
    $response = array(
        "error" => true,
        "message" => "Invalid length for title(30) or category(50)."
    );
    echo json_encode($response);
    exit;
}

// Check for invalid characters in title and category
$invalidCharacters = ["<", ">", "/"];
foreach ($invalidCharacters as $char) {
    if (strpos($book_title, $char) !== false || strpos($book_category, $char) !== false) {
        $response = array(
            "error" => true,
            "message" => "Invalid characters detected in title or category (></)."
        );
        echo json_encode($response);
        exit;
    }
}

// Check if the category is already in the database
$sqlCheckCategory = "SELECT id FROM `book_category` WHERE category = ?";
$stmtCheckCategory = mysqli_prepare($conn, $sqlCheckCategory);
mysqli_stmt_bind_param($stmtCheckCategory, "s", $book_category);
mysqli_stmt_execute($stmtCheckCategory);
mysqli_stmt_store_result($stmtCheckCategory);

// If the category already exists, return an error
if (mysqli_stmt_num_rows($stmtCheckCategory) > 0) {
    $response = array(
        "error" => true,
        "message" => "Category already exists."
    );
    echo json_encode($response);
    exit;
}

// Insert the data into the database
$sqlInsertCategory = "INSERT INTO `book_category` (`title`, `category`) VALUES (?, ?)";
$stmtInsertCategory = mysqli_prepare($conn, $sqlInsertCategory);
mysqli_stmt_bind_param($stmtInsertCategory, "ss", $book_title, $book_category);

$response = array();

if (mysqli_stmt_execute($stmtInsertCategory)) {
    $response["error"] = false;
    $response["message"] = "Your Data Inserted Successfully...";
} else {
    $response["error"] = true;
    $response["message"] = "Error inserting data: " . mysqli_error($conn);
}

// Return the response as JSON
echo json_encode($response);

mysqli_stmt_close($stmtInsertCategory);
mysqli_close($conn);
exit;
?>
