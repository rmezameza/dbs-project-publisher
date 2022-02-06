<!DOCTYPE html>
<html lang="de">
    <head>
        <title>Bahoe Books - Buchzuweisung</title>
    </head>

    <body>
        <div class="container">
            <?php
            include_once 'func/class/AuthorHandler.php';
            include_once 'func/inc/sec.inc.php';

            $authorHandler = new AuthorHandler();
            $authorID = isset($_GET['autorid']) ? htmlentities($_GET['autorid']) : null;
            checkInputValueForNull($authorID);

            $writtenBooks = $authorHandler->getBooksForSpecificAuthor($authorID);
            $authorFullName = $authorHandler->fullAuthorName($authorID);

            $bookIDs = array();

            for($i = 0; $i < count($writtenBooks); ++$i) {
                $bookIDs[$i] = $writtenBooks[$i]['BUCH_ID'];
            }

            $notWrittenBooks = $authorHandler->getBooksNotFromAuthor($bookIDs);

            ?>
            <h1>Buchzuweisung für</h1>
            <h2 class="mb-5"><?php echo $authorFullName; ?></h2>

            <form method="post"
                  action="index.php?site=autor-absenden&op=buch-zuweisung&autorid=<?php echo $authorID; ?>"
                  class="mb-4">


                <div class="mb-5">
                    <label for="select_book" class="col-form-label">Buchlager:</label>
                    <select class="form-select" aria-label="select_book" name="book_id" required>
                        <option selected disabled="disabled">Bitte Buch auswählen</option>
                        <?php
                            foreach($notWrittenBooks as $book) {
                        ?>
                                <option value="<?php echo $book['BUCH_ID']; ?>">
                                    <?php echo $book['ISBN'] . "  - " . $book['TITEL']; ?>
                                </option>
                        <?php
                            }
                        ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary" title="Buch zuweisen">Zuweisen</button>
                <a class="btn btn-secondary" href="index.php?site=autor-detail&autorid=<?php echo $authorID; ?>" title="Zurück zur/m Autor:in">
                    Zurück
                </a>
            </form>
        </div>
    </body>
</html>
