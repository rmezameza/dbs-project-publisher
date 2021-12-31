<!DOCTYPE html>
<html lang="de">
    <head>
        <meta charset="UTF-8">
        <title>Bahoe Book - Buch bearbeiten</title>
    </head>

    <body>
        <?php
            require_once 'func/class/BookHandler.php';

            $bookHandler = new BookHandler();
            $bookID = isset($_GET['buchid']) ? htmlentities($_GET['buchid']) : null;
            $previousSiteType = isset($_GET['type']) ? htmlentities($_GET['type']) : null;

            if($bookID == null || !is_numeric($bookID) || $previousSiteType == null) {
                include_once 'error/not_allowed.php';
                exit;
            }

            $bookArray = $bookHandler->getSpecificBook($bookID);

            foreach($bookArray as $book) :
        ?>
            <div class="container">
                <h1>Buch bearbeiten:</h1>
                <h2><?php echo $book['TITEL']; ?></h2>

                <p>
                    <img class="img-thumbnail"
                         src="img/book_covers/<?php echo $book['COVER']; ?>"
                         alt="Buch Cover">
                </p>
                <!-- Form for editing a book. It will contain the actual data for overview. -->
                <form method="post"
                      action="index.php?site=buchformular-senden&buchid=<?php echo $book['BUCH_ID']; ?>"
                      class="mb-4">

                    <!-- Change ISBN number -->
                    <div class="mb-3">
                        <label for="change_isbn" class="col-form-label">ISBN:</label>
                        <input type="text"
                               class="form-control"
                               id="change_isbn"
                               name="isbn"
                               maxlength="13"
                               placeholder="<?php echo $book['ISBN']; ?>">
                    </div>

                    <!-- Change book title -->
                    <div class="mb-3">
                        <label for="change_title" class="col-form-label">Titel:</label>
                        <input type="text"
                               class="form-control"
                               id="change_title"
                               name="title"
                               maxlength="80"
                               placeholder="<?php echo $book['TITEL']; ?>">
                    </div>

                    <!-- Change total number of pages -->
                    <div class="mb-3">
                        <label for="change_page_nr" class="col-form-label">Seitenanzahl:</label>
                        <input type="number"
                               class="form-control"
                               id="change_page_nr"
                               name="page_nr"
                               placeholder="<?php echo $book['SEITEN_ANZ']; ?>">
                    </div>

                    <!-- Change price -->
                    <div class="mb-3">
                        <label for="change_price" class="col-form-label">Preis:</label>
                        <input type="number"
                               class="form-control"
                               id="change_price"
                               name="price"
                               placeholder="<?php echo $book['PREIS']; ?>">
                    </div>

                    <!-- Change year of release -->
                    <div class="mb-3">
                        <label for="change_release_year" class="col-form-label">Erscheinungsjahr:</label>
                        <input type="number"
                               class="form-control"
                               id="change_release_year"
                               name="release_year"
                               placeholder="<?php echo $book['ERSCH_JAHR']; ?>">
                    </div>

                    <!-- Change genre -->
                    <!-- Change novelty status -->
                    <!-- Change book description -->

                    <!-- Submit and Back Button -->
                    <button type="submit" class="btn btn-primary">Buch bearbeiten</button>
                    <a class="btn btn-secondary"
                       href="index.php?site=<?php echo $previousSiteType; ?>">Zurück</a>
                </form>
            </div>
        <?php endforeach; ?>
    </body>
</html>
