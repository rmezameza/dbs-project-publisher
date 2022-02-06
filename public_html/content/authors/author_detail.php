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

            $authorFullName = $authorHandler->fullAuthorName($authorID);



            ?>
            <div class="d-flex flex-row-reverse">
                <div class="p-2">
                    <a class="link-dark"
                       onClick="return confirm('Den / Die Autor:in >><?php echo $authorFullName; ?><< wirklich löschen?')"
                       href="index.php?site=autor-absenden&op=delete&autorid=<?php echo $authorID; ?>&autorname=<?php echo $authorFullName; ?>">
                        Löschen
                    </a>
                </div>
                <div class="p-2">
                    <p>
                        <a class="link-dark"
                           href="index.php?site=autoredit&autorid=<?php echo $authorID ?>";
                           title="Autor:in bearbeiten">
                            Bearbeiten
                        </a>
                    </p>
                </div>
            </div>
            <h1><?php echo $authorFullName; ?></h1>
            <h2 class="mt-5">Biographie:</h2>
            <p><?php echo $authorArray[0]['BIO']; ?></p>
            <div class="row">
                <div class="col">
                    <h2 class="mt-5">Bücher:</h2>
                </div>
                <div class="col">
                    <div class="d-flex flex-row-reverse">
                        <div class="pt-5">
                            <a class="link-dark" href="index.php?site=buch-autor-zuweisung&autorid=<?php echo $authorID; ?>">Buch hinzufügen</a>
                        </div>
                    </div>
                </div>
            </div>
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
                        </a>
                        <a class="link-dark"
                           onClick="return confirm('Das Buch >><?php echo $book['TITEL']; ?><< wirklich für diese:n Autor:in löschen?')"
                           href="index.php?site=autor-absenden&op=buch-loeschen&autorid=<?php echo $authorID; ?>&buchid=<?php echo $book['BUCH_ID']; ?>">
                            Delete
                        </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </body>
</html>
