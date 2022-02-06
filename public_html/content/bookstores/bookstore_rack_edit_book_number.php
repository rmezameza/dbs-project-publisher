<!DOCTYPE html>
<html lang="de">
    <head>
        <title>Bahoe Books - Buchlager befüllen</title>
    </head>

    <body>
        <div class="container">
            <h1>Gelagerte Bücher bearbeiten</h1>

            <?php
                include_once 'func/class/BookHandler.php';
                include_once 'func/class/BookstoreHandler.php';

                $bookHandler = new BookHandler();
                $bookstoreHandler = new BookstoreHandler();

                $books = $bookHandler->getAllBooks(null, null);
                $bookstores = $bookstoreHandler->getBookstoreAndCapacity(null);
            ?>

            <form method="post"
                  action="index.php?site=buecher-ins-buchlager"
                  class="mb-4">

                <!-- Buchlager -->
                <div class="mb-3">
                    <label for="select_bookstore" class="col-form-label">Buchlager:</label>
                    <select class="form-select" aria-label="select_bookstore" name="bookstore_id" required>
                        <option selected disabled="disabled">Bitte Buchlager auswählen</option>
                        <?php
                            foreach($bookstores as $store) {
                                if(($store['GESAMTBUECHER'] + 100) >= $store['GESAMTKAPAZITAET'] && $store['GESAMTBUECHER'] != 0 &&$store['GESAMTKAPAZITAET'] != 0 ) {
                        ?>
                                    <option value="<?php echo $store['LAG_ID']; ?>" disabled="disabled">
                                        <?php echo $store['LAG_STRASSE'] . ", " . $store['LAG_PLZ'] . " " . $store['LAG_ORT']; ?>
                                    </option>
                                <?php } else { ?>
                                    <option value="<?php echo $store['LAG_ID']; ?>">
                                        <?php echo $store['LAG_STRASSE'] . ", " . $store['LAG_PLZ'] . " " . $store['LAG_ORT']; ?>
                                    </option>
                        <?php
                                }
                            }
                        ?>
                    </select>
                </div>

                <!-- Buecher -->
                <div class="mb-3">
                    <label for="select_book" class="col-form-label">Bücher:</label>
                    <select class="form-select" aria-label="select_book" name="bookid_genre" required>
                        <option selected disabled="disabled">Bitte ein Buch auswählen</option>
                        <?php
                            foreach($books as $book) {
                                if($book['GENRE'] == null) {
                                    echo "<option value='{$book['BUCH_ID']}#{$book['GENRE']}' disabled='disabled'>{$book['TITEL']}</option>";
                                }
                                else {
                                    echo "<option value='{$book['BUCH_ID']}#{$book['GENRE']}'>{$book['TITEL']}</option>";
                                }
                            }
                        ?>
                    </select>
                </div>

                <!-- Ask if it's a book deletion -->
                <div class="mb-3">
                    <p class="pt-2">Löschen?</p>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="bookstore_book_deletion"
                               id="bookstore_book_deletion_yes" value="1">
                        <label class="form-check-label" for="bookstore_book_deletion_yes">
                            Ja
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="bookstore_book_deletion"
                               id="bookstore_book_deletion_no" value="0" checked>
                        <label class="form-check-label" for="bookstore_book_deletion_no">
                            Nein
                        </label>
                    </div>
                </div>

                <!-- Stückanzahl -->
                <div class="mb-3">
                    <label for="amount_of_books" class="col-form-label">Stückanzahl:</label>
                    <input type="number"
                           class="form-control"
                           id="amount_of_books"
                           name="amount_of_books">
                </div>

                <button type="submit" class="btn btn-primary" title="Status der Buchanzahl ändern">Absenden</button>
            </form>
        </div>
    </body>
</html>