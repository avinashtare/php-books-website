<?php
require "../../database/config.php";
// user auth
require "../middleware/userAuth.php";
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
    <link rel="stylesheet" href="/assets/css/dashboard/category.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- tastify -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <title>Category - Books</title>
</head>

<body>
    <div class="container">
        <!-- Navigation -->
        <?php include "../../components/admin/nav.php" ?>

        <div class="message-modal">

        </div>
        <!-- code -->
        <!-- add book category -->
        <div class="category_forms">
            <form method="post" name="add_category" id="add_category_form">
                <div class="form-container">
                    <h2>Add Book Category</h2>
                    <div class="form-group">
                        <label class="form-label" for="name">Title</label>
                        <input class="form-input" type="text" id="add-book-title" name="title" placeholder="Enter Title" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="name">Category</label>
                        <input class="form-input" type="text" id="add-book-category" name="category" placeholder="Enter Book Category" required>
                    </div>

                    <button class="form-button" type="submit">Add</button>
                </div>
            </form>

            <!-- delete book category -->
            <form method="post" name="add_category" id="delete_category_form">
                <div class="form-container delete_category_form">
                    <h2>Delete Book Category</h2>
                    <div class="form-group">
                        <label class="form-label" for="name">Category</label>
                        <input class="form-input search-modal-input" type="text" id="delete-book-category" name="title" placeholder="Enter Delete Category" required>
                        <!-- add search category here -->
                        <div class="search-modal hide" id="delete-category-lists">
                        </div>
                    </div>
                    <button class="form-button btn-danger" type="submit">Delete</button>
                </div>

            </form>
        </div>
        <!-- footer -->
        <?php include "../../components/footer.php" ?>
        <!-- script -->
        <script src="/assets/js/main.js"></script>
        <script src="/assets/js/nav.js"></script>
        <script src="/assets/js/dashboard/category.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    </div>
</body>

</html>