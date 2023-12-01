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
    <link rel="stylesheet" href="/assets/css/dashboard/book.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- tastify -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <title>book - Books</title>
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
            <!-- add book -->
            <form method="post" action="/admin/dashboard.php" id="add_book_form">
                <div class="form-container">
                    <h2>Add New Book</h2>
                    <div class="form-group">
                        <label class="form-label" for="name">Book Name</label>
                        <input class="form-input" type="text" id="add_book_name" name="book_name" placeholder="Enter Book Name" required>
                    </div>
                    <div class="form-group category-group">
                        <label class="form-label" for="name">Choose Book Category</label>
                        <input class="form-input search-modal-input" type="text" id="add_book_category" name="book_category" placeholder="Enter Book Category" required>
                        <div class="search-modal hide" id="search_modal_category">
                            <!-- <span data-id="34">Serach .. 1</span> -->
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="name">Book Poster Url</label>
                        <input class="form-input" type="url" id="add_book_poster_url" name="add_book_poster_url" placeholder="Enter Book Poster" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="name">Book Download Url</label>
                        <input class="form-input" type="url" id="add_book_download_url" name="book_download_url" placeholder="Enter Book Download URL" required>
                    </div>

                    <button class="form-button" type="submit">Add Book</button>
                </div>
            </form>

            <!-- delete book -->
            <form method="post" action="/admin/dashboard.php" id="delete_book_name_form">
                <div class="form-container">
                    <h2>Delete New Book</h2>
                    <div class="form-group category-group">
                        <label class="form-label" for="name">Choose Book Category</label>
                        <input class="form-input search-modal-input" type="text" id="delete_book_category" name="book_category" placeholder="Enter Book Category" required>
                        <div class="search-modal hide">
                            <!-- <span data-id="34">Serach .. 1</span> -->
                        </div>
                    </div>
                    <div class="form-group bookname-group">
                        <label class="form-label" for="name">Choose Book Name</label>
                        <input class="form-input search-modal-input" type="text" id="delete_book_name" name="delete_book_name" placeholder="Enter Book Name" required>
                        <div class="search-modal hide">
                            <!-- <span data-id="34">Serach .. 1</span> -->
                        </div>
                    </div>
                    <button class="form-button btn-danger" type="submit">Delete Book</button>
                </div>
            </form>
        </div>
        <!-- footer -->
        <?php include "../../components/footer.php" ?>
        <!-- script -->
        <script src="/assets/js/main.js"></script>
        <script src="/assets/js/nav.js"></script>
        <script src="/assets/js/dashboard/book.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    </div>
</body>

</html>