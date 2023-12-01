<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- favicon -->
    <link rel="shortcut icon" href="./assets/images/app/logo.png" type="image/x-icon">
    <!-- stylesheet -->
    <link rel="stylesheet" href="/assets/css/main.css">
    <link rel="stylesheet" href="/assets/css/nav.css">
    <link rel="stylesheet" href="/assets/css/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>4O4 - Books</title>
    <style>
        .error h1{
            text-align: center;
            margin-top: 80px;
            font-size: 4rem;
            color: var(--light-orange);
        }
        .error h2{
            text-align: center;
            margin-top: 50px;
            font-size: 3rem;
            color: var(--simple-white);
        }
        .error p{
            margin-top: 10px;
            text-align: center;
            color: var(--simple-white);
        }

        .error .redirect-home{
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .error .redirect-home a{
            text-decoration: none;
            color: var(--simple-white);
            margin: 20px 0;
            border-radius: 10px;
            padding: 6px 12px;
            border: 0;
            background-color: var(--light-orange);
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Navigation -->
        <?php include "./components/nav.php" ?>
        <!-- code -->
        <div class="error">
            <h1>4O4</h1>
            <h2>Page Not Found</h2>
            <p>Oops!The Page You Are Looking Does Not Exist!It Right Be Moved Or Delete.</p>
            <div class="redirect-home">
                <a href="/">Go To Home</a>
            </div>
        </div>
        <!-- add here code  -->
        <!-- footer -->
        <?php include "./components/footer.php" ?>

        
        <!-- script -->
        <script src="/assets/js/nav.js"></script>
    </div>
</body>

</html>