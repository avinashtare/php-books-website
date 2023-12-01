<?php
// Include configuration and start session
require "../database/config.php";
session_start();

// Get request method
$request = ($_SERVER["REQUEST_METHOD"]);

// Validate and sanitize input
function sanitizeInput($input)
{
    return trim(htmlspecialchars($input));
}

// Authenticate user
function authenticateUser($username, $password, $conn)
{
    try {
        // Prepare SQL statement to fetch user data based on username
        $sql = "SELECT id, password FROM users WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        // Check if exactly one user exists with the given username
        if ($result && mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            // Verify hashed password
            if (password_verify($password, $row["password"])) {
                return $row["id"]; // Return user ID on successful authentication
            }
        }
    } catch (\Throwable $th) {
        // Handle exceptions if any
    }
    return null; // Return null on unsuccessful authentication
}

// Handle login attempt
if ($request == "POST") {
    // Sanitize user inputs
    $username = sanitizeInput($_POST["user"]);
    $password = sanitizeInput($_POST["password"]);

    // Check for non-empty inputs
    if (!empty($username) && !empty($password)) {
        // Authenticate user
        $user_id = authenticateUser($username, $password, $conn);
        if ($user_id) {
            // Store user ID in session and redirect to dashboard
            $_SESSION["id"] = $user_id;
            header("location: /admin/dashboard.php");
            exit();
        } else {
            $auth_form_error = true; // Set authentication error flag
        }
    } else {
        $auth_form_error = true; // Set authentication error flag for empty inputs
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- favicon -->
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <title>Admin Login - Books</title>
    <link rel="stylesheet" href="/assets/css/main.css">
    <link rel="stylesheet" href="/assets/css/nav.css">
    <link rel="stylesheet" href="/assets/css/footer.css">
    <link rel="stylesheet" href="/assets/css/adminLogin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div class="container">
        <?php include "../components/nav.php" ?>
        <form method="post" action="/admin/login.php">
            <div class="form-container <?php echo isset($auth_form_error) && $auth_form_error ? 'form-container-error' : ''; ?>">
                <h2>Admin Login</h2>
                <?php if (isset($auth_form_error) && $auth_form_error) : ?>
                    <span class="show-error-span">Username and password do not match.</span>
                <?php endif; ?>
                <div class="form-group">
                    <label class="form-label" for="name">User</label>
                    <input class="form-input" type="text" id="user" name="user" placeholder="Enter UserName">
                </div>
                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <input class="form-input" type="password" id="password" name="password" placeholder="Enter Password">
                    <a class="form-forgotPass" href="/">Forgot Password</a>
                </div>
                <button class="form-button" type="submit">Login</button>
            </div>
        </form>
        <?php include "../components/footer.php" ?>
        <script src="/assets/js/nav.js"></script>
    </div>
</body>

</html>