<?php
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(400);
    echo "<h1>400 | Bad Request</h1>";
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
$book_name = substr($requestData["name"], 0, 30);
$category = intval($requestData["category"]);
$book_poster = filter_var(substr($requestData["poster"], 0, 500)) ? $requestData["poster"] : "";
$book_download_url = filter_var(substr($requestData["downlaod"], 0, 500)) ? $requestData["downlaod"] : "";

$error_inputs = [];

// Validate name
if (strlen($book_name) < 2 || preg_match('/[<>\/]/', $book_name)) {
    array_push($error_inputs,"book_category");
    $response = array(
        "error" => true,
        "error_input"=> $error_inputs,
        "message" => "The book name must be at a characters and should not contain < > / characters."
    );
    echo json_encode($response);
    exit;
}

// Validate category ID
if ($category <= 0) {
    array_push($error_inputs,"book_category");
    $response = array(
        "error" => true,
        "error_input"=> $error_inputs,
        "message" => "Invalid category ID."
    );
    echo json_encode($response);
    exit;
}



// Check if the category exists
$sqlCheckCategory = "SELECT id FROM `book_category` WHERE id = ?";
$stmtCheckCategory = mysqli_prepare($conn, $sqlCheckCategory);
mysqli_stmt_bind_param($stmtCheckCategory, "i", $category);
mysqli_stmt_execute($stmtCheckCategory);
mysqli_stmt_store_result($stmtCheckCategory);

if (mysqli_stmt_num_rows($stmtCheckCategory) === 0) {
    array_push($error_inputs,"book_category");
    $response = array(
        "error" => true,
        "error_input"=> $error_inputs,
        "message" => "Category does not exist."
    );
    echo json_encode($response);
    exit;
}


// poster validation
$allowedImageFormats = array("jpg", "jpeg", "png", "gif","svg");
$posterExtension = strtolower(pathinfo($book_poster, PATHINFO_EXTENSION));

if (!filter_var($book_poster, FILTER_VALIDATE_URL) || !in_array($posterExtension, $allowedImageFormats)) {
    array_push($error_inputs,"book_poster");
    $response = array(
        "error" => true,
        "error_input"=> $error_inputs,
        "message" => "Invalid poster URL or format. Only JPG, JPEG, PNG, and GIF formats are allowed."
    );
    echo json_encode($response);
    exit;
}

// downlaod link validation
if (!filter_var($book_download_url, FILTER_VALIDATE_URL)) {
    array_push($error_inputs,"downlaod_link");
    $response = array(
        "error" => true,
        "error_input"=> $error_inputs,
        "message" => "Invalid download URL."
    );
    echo json_encode($response);
    exit;
}

// Insert the data into the database
$sqlInsertBook = "INSERT INTO `books` (`book_name`, `book_poster`, `downlaod_link`, `category_id`) VALUES (?, ?, ?, ?)";
$stmtInsertBook = mysqli_prepare($conn, $sqlInsertBook);
mysqli_stmt_bind_param($stmtInsertBook, "sssi", $book_name, $book_poster, $book_download_url, $category);

$response = array();

if (mysqli_stmt_execute($stmtInsertBook)) {
    $response["error"] = false;
    $response["message"] = "Book data inserted successfully.";
} else {
    $response["error"] = true;
    $response["message"] = "Error inserting data: " . mysqli_error($conn);
}

// Return the response as JSON
echo json_encode($response);

mysqli_stmt_close($stmtInsertBook);
mysqli_close($conn);
exit;
?>
