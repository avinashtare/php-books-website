    <?php
    // ways contect to a MySQL database
    // 1. MySQLI Extension\
    // 2. PDO (PHP DATA OBJECT)

    // connecting to the database
    $servername = "localhost";
    $username = "root";
    $database = "books_web";
    $password = "";
    // create a connection object
    global $conn;
    try {
        $conn = mysqli_connect($servername, $username, $password, $database);
    } catch (\Throwable $th) {
    }
    ?>