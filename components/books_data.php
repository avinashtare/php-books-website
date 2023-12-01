<div class="booksList-section">
    <?php
    if (count($books_category) != 0) {
        echo '<h1 class="heading">' . $books_category["title"] . '</h1>';
        echo '<p class="short-info">' . $books_category["category"] . '</p>';
    } else {
        echo '<h1 class="heading">Thare Is Not Data To Show</h1>';
        echo '<p class="short-info">This file will be deletd or moved.</p>';
    }
    ?>

    <div class="books-links">
        <?php
        $myArray = shuffle($books_data);

        for ($i = 0; $i < count($books_data); $i++) {
            $book_name =  $books_data[$i]['book_name'];
            $book_poster =  $books_data[$i]['book_poster'];
            $downlaod_link =  $books_data[$i]['downlaod_link'];


            echo  ' <div class="single_book">
                    <img class="book_poster" src="' . $book_poster . '" alt="book">
                    <span class="book_name">' . $book_name . '</span>
                    <div class="downlaod">
                    <a href="' . $downlaod_link . '" target="_blank">Downlaod</a>
                    </div>
                </div>';
        };

        ?>
        <!-- <div class="single_book">
            <img class="book_poster" src="https://online.anyflip.com/qtawi/ewyp/files/mobile/1.jpg?1619591255" alt="book">
            <span class="book_name">Python</span>
            <div class="downlaod">
                <a href="/" target="_blank">Downlaod</a>
            </div>
        </div> -->


    </div>
</div>