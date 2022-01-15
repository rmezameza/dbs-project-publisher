<!DOCTYPE html>
<html lang="de">
    <head>
        <title>Bahoe Books - Detail zum/r Autor:in</title>
    </head>

    <body>
        <div class="container">
            <?php
            include_once 'func/class/AuthorHandler.php';

            $authorHandler = new AuthorHandler();
            $authorID = isset($_GET['autorid']) ? htmlentities($_GET['autorid']) : null;

            if($authorID == null) {
                include_once 'error/not_allowed.html';
                exit;
            }

            $authorArray = $authorHandler->getAllAuthorsSortedByName("autor_id = {$authorID}");
            $booksArray = $authorHandler->getBooksForSpecificAuthor($authorID);



            //foreach($authorArray as $author) :
                ?>
                <h1><?php echo $authorHandler->fullAuthorName($authorID); ?></h1>
                <h2 class="mt-5">Biographie:</h2>
                <p><?php echo $authorArray[0]['BIO']; ?></p>
                <h2 class="mt-5">Bücher:</h2>
                <div class="row text-center">
                    <?php
                        foreach($booksArray as $book) :
                    ?>
                        <div class="col col-lg-auto">
                            <a href="index.php?site=buchdetail&buchid=<?php echo $book['BUCH_ID']; ?>"
                               class="link-dark"
                               title="<?php echo $book['TITEL']; ?>">
                            <div class="row">
                                <div class="col text-nowrap">
                                    <img src="img/book_covers/<?php echo (isset($book['COVER'])) ? $book['COVER'] : "book_cover_na.jpg"; ?>"
                                         class="img-thumbnail"
                                         alt="<?php echo $book['TITEL']; ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col text-nowrap">
                                    <p><?php echo $book['TITEL']; ?></p>
                                </div>
                            </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php //endforeach; ?>
        </div>
    </body>
</html>
