<div class="booksList-section">
    <?php
    if (count($books_category) == 0) {
        echo '<h1 class="heading">Thare Is Not Data To Show</h1>';
    } else {
        echo '<h1 class="heading">Our Books</h1>';
    }
    ?>
    <p class="short-info">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Blanditiis laborum, quasi magni similique quam mollitia? Quam alias culpa quia quos.</p>

    <div class="books-links">
        <?php
        if (count($books_category) == 0) {
            echo "<h1>Error</h1>";
        } else {

            for ($i = 0; $i < count($books_category); $i++) {
                $id =  $books_category[$i]['id'];
                $title =  $books_category[$i]['title'];
                $category =  $books_category[$i]['category'];


                echo  '<a class="book-block" href="/books.php/' . $id . '">
                <span>' . $title . '</span>
                <br>
                <span>' . $category . '</span>
                        </a>';
            };
        };
        ?>
        <!-- <a class="book-block" href="/">
                    <span>Textbook</span>
                    <br>
                    <span>12TH Maharashtra All Books</span>
                </a> -->

    </div>
</div>