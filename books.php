<!-- database config -->
<?php
require "./database/config.php";
$books_data = [];
$books_category = [];
$slug = "/";

if (isset($_SERVER["PATH_INFO"]) && $_SERVER["PATH_INFO"] !== "/") {
    $slug =  intval(str_replace("/", "", $_SERVER["PATH_INFO"]));
    try {
        // get all books
        $sql = "SELECT * FROM `books` WHERE category_id = " . $slug . ";";
        $result = mysqli_query($conn, $sql);

        $num_rows = mysqli_num_rows($result);

        if ($num_rows > 0) {
            $books_data = mysqli_fetch_all($result, MYSQLI_ASSOC);
        }

        // get book category data
        $sql = "SELECT * FROM `book_category` WHERE id = " . $slug . ";";

        $result2 = mysqli_query($conn, $sql);

        $num_rows = mysqli_num_rows($result2);
        
        if ($num_rows > 0) {
            $books_category = mysqli_fetch_array($result2, MYSQLI_ASSOC);
        }
    } catch (\Throwable $th) {
    };
} else {
    try {
        $sql = "SELECT * FROM `book_category`";
        $result = mysqli_query($conn, $sql);

        $num_rows = mysqli_num_rows($result);

        if ($num_rows > 0) {
            $books_category = mysqli_fetch_all($result, MYSQLI_ASSOC);
        }
    } catch (\Throwable $th) {
    };
};
?>

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
    <link rel="stylesheet" href="/assets/css/books.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <?php
  
    if (count($books_category) === 0) {
        echo '<title>Our Books - Books</title>';
    }
    else{
        if($slug == "/"){
            echo '<title>Our Books -Books</title>';
        }
        else{
            echo '<title>'.$books_category["title"].' - Books</title>';
        }
    }
    ?>
</head>

<body>
    <div class="container">
        <!-- Navigation -->
        <?php include "./components/nav.php" ?>
        <!-- code -->
        <!-- for book links -->
        <?php
        if ($slug == "/") {
            include "./components/books_category.php";
        } else {
            include "./components/books_data.php";
        }

        ?>
        <!-- footer -->
        <?php include "./components/footer.php" ?>

        <!-- script -->
        <script src="/assets/js/nav.js"></script>
    </div>
</body>

</html>