<!DOCTYPE html>
<html lang="de">
    <?php
        require_once 'func/class/BookHandler.php';
        require_once 'func/inc/book.inc.php';
        require_once 'func/inc/string_manager.inc.php';

        $bookHandler = new BookHandler();

        // Get the type of book (genre / novelty) and get all the books of that specific type.
        // Before that -> Sanitize url input
        $bookType = validateBookType();
        $sqlName = "";
        $typeName = "";

        if(isset($bookType["shortname"])) {
            $sqlName = $bookType["shortname"];
            $typeName = $bookType["longname"];
        }
    ?>

    <head>
        <meta charset="UTF-8">
        <title>Bahoe Books - <?php echo $typeName; ?></title>
    </head>
    <body>
        <h1 class="h1 mb-5"><?php echo $typeName; ?></h1>
        <div class="container">
            <?php

                $books = $bookHandler->getAllBooks($sqlName);

                if(!$books) {
                    echo "<h2 class='h2 mt-4'>Derzeit keine Bücher vorhanden.</h2>";
                }
                else {
                    foreach($books as $book) :
                        $authors = $bookHandler->getAuthorsForBook($book['BUCH_ID']);
            ?>
                        <div class="row mb-5 border-bottom">
                            <div class="col col-lg-4">
                                <img class="img-thumbnail"
                                     src="img/book_covers/<?php echo $book['COVER']; ?>"
                                     alt="<?php echo $book['TITEL']; ?>">
                            </div>
                            <div class="col col-lg-6">
                                <?php
                                    if($authors) {
                                ?>
                                    <div class="row">
                                        <p class="small">
                                            <?php
                                                $count = 0;
                                                foreach($authors as $author) :
                                                    if($count > 0) {
                                                        echo ", ";
                                                    }

                                                    echo $author['AU_VORNAME'] . " " . $author['AU_NACHNAME'];
                                                    ++$count;
                                                endforeach;
                                            ?>

                                        </p>
                                    </div>
                                <?php } ?>
                                <div class="row">
                                    <h3 class="h3"><?php echo $book['TITEL']; ?></h3>
                                    <p><?php
                                            if($book['KURZ_BESCHR']) {
                                                echo shortText($book['KURZ_BESCHR'], 200);
                                            }
                                       ?>
                                    </p>
                                </div>
                                <div class="d-flex flex-row-reverse">
                                    <div class="p-2">
                                        <p>Delete</p>
                                    </div>
                                    <div class="p-2">
                                        <p>
                                            <a class="link-dark"
                                               href="index.php?site=buchedit&type=buecher&buchid=<?php echo $book['BUCH_ID']; ?>"
                                               title="Buch bearbeiten">
                                                Edit
                                            </a>
                                        </p>
                                    </div>
                                    <div class="p-2">
                                        <p>
                                            <a class="link-dark"
                                               href="index.php?site=buchdetail&buchid=<?php echo $book['BUCH_ID']; ?>"
                                               title="Buchdetail">
                                                Detail
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
            <?php
                    endforeach;
                }
            ?>
        </div>
    </body>
</html>
