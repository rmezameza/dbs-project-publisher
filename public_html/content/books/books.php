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

                $books = $bookHandler->getAllBooks($sqlName, null);

                if(!$books) {
                    echo "<h2 class='h2 mt-4'>Derzeit keine Bücher vorhanden.</h2>";
                }
                else {
                    foreach($books as $book) :
                        $authors = $bookHandler->getAuthorsForBook($book['BUCH_ID']);
            ?>
                        <div class="row mb-5">
                            <div class="col col-lg-4">
                                <img class="img-fluid custom-image-class"
                                     src="img/book_covers/<?php
                                                                if($book['COVER'] == null) {
                                                                    echo "book_cover_na.jpg";
                                                                }
                                                                else {
                                                                    echo $book['COVER'];
                                                                }
                                                           ?>"
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
                                            else {
                                                echo "Momentan keine Kurzbeschreibung vorhanden.";
                                            }
                                       ?>
                                    </p>
                                </div>
                                <div class="d-flex flex-row-reverse">
                                    <div class="p-2">
                                        <p>
                                            <a class="link-dark"
                                               onClick="return confirm('Das Buch >><?php echo $book['TITEL']; ?><< wirklich löschen?')"
                                               href="index.php?site=buch-absenden&op=buch-loeschen&type=<?php echo $sqlName; ?>&buchid=<?php echo $book['BUCH_ID']; ?>">
                                                Delete
                                            </a>
                                        </p>
                                    </div>
                                    <div class="p-2">
                                        <p>
                                            <a class="link-dark"
                                               href="index.php?site=buchedit&prev=buecher&type=<?php echo $sqlName; ?>&buchid=<?php echo $book['BUCH_ID']; ?>"
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
                        <hr class="text-decoration-line-through mt-3">
            <?php
                    endforeach;
                }
            ?>
        </div>
    </body>
</html>
