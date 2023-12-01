<?php
session_start();
session_regenerate_id();

// Get the user ID from the session, and ensure it's a valid integer
$user_id = isset($_SESSION["id"]) ? intval($_SESSION["id"]) : 0;
$userExist = false;

// Check if the user ID is greater than 0 (valid)
if ($user_id > 0) {
    // Prepare the SQL statement with a placeholder for the user ID
    $sql = "SELECT * FROM `users` WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);

    // Bind the user ID to the prepared statement as an integer parameter
    mysqli_stmt_bind_param($stmt, "i", $user_id);

    // Execute the prepared statement
    mysqli_stmt_execute($stmt);

    // Get the result set
    $result = mysqli_stmt_get_result($stmt);

    // Check if exactly one row is returned from the database
    if (mysqli_num_rows($result) == 1) {
        $userExist = true;
    }

    // Close the prepared statement
    mysqli_stmt_close($stmt);
}

// if user not login redirect him
if (!$userExist) {
    header("location: /admin/logout.php");
    exit;
};

?>