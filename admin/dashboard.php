<?php
require "../database/config.php";
// user auth
require "./middleware/userAuth.php";
?>

<!-- html code start -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- favicon -->
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <!-- stylesheet -->
    <link rel="stylesheet" href="/assets/css/main.css">
    <link rel="stylesheet" href="/assets/css/nav.css">
    <link rel="stylesheet" href="/assets/css/footer.css">
    <link rel="stylesheet" href="/assets/css/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- tastify -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <title>Dashboard - Books</title>
</head>

<body>
    <div class="container">
        <!-- Navigation -->
        <?php include "../components/admin/nav.php" ?>

       <h1><a href="/admin/dashboard/book.php">Book</a></h1>
       <h1><a href="/admin/dashboard/category.php">Category</a></h1>

        
        <!-- footer -->
        <?php include "../components/footer.php" ?>
        <!-- script -->
        <script src="/assets/js/nav.js"></script>
        <script src="/assets/js/dashboard.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    </div>
</body>

</html>