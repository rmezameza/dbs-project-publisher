<!DOCTYPE html>
<html lang="de">
    <head>
        <title>Bahoe Books - Regal erstellen</title>
    </head>

    <body>
        <?php
            include_once 'func/class/BookstoreHandler.php';
            include_once 'func/inc/sec.inc.php';

            $bookstoreHandler = new BookstoreHandler();
            $bookstoreID = isset($_GET['bookstoreid']) ? htmlentities($_GET['bookstoreid']) : null;
            $op = isset($_GET['site']) ? htmlentities($_GET['site']) : null;

            checkInputValueForNull($bookstoreID);
            checkInputValueForNull($op);

            $bookstoreArray = $bookstoreHandler->getBookstoreAndCapacity("lag_id = {$bookstoreID}");
        ?>
        <div class="container">
            <h1>Regal erstellen für</h1>
            <h2 class="mb-5"><?php echo $bookstoreArray[0]['LAG_STRASSE'] . ", " . $bookstoreArray[0]['LAG_PLZ'] . " " . $bookstoreArray[0]['LAG_ORT']; ?></h2>
            <!-- Form for creating a book. Title and box for checking novelty status of a book are required fields -->
            <form method="post"
                  action="index.php?site=buchlager-submit&op=<?php echo $op . "&bookstoreid={$bookstoreID}"; ?>"
                  class="mb-4">

                <!-- Genre -->
                <div class="mb-3">
                    <label for="add_genre" class="col-form-label">Bitte Genre für das Regal auswählen:</label>
                    <select class="form-select" aria-label="add_genre" name="genre" required>
                        <option selected disabled="disabled">Bitte auswählen</option>
                        <option value="politics">Politics</option>
                        <option value="literature">Literature</option>
                        <option value="history">History</option>
                        <option value="theory">Theory</option>
                        <option value="comics">Comics</option>
                        <option value="art-books">Art Books</option>
                        <option value="kids">Kids</option>
                    </select>
                </div>

                <!-- Capacity -->
                <div class="mb-5">
                    <label for="add_capacity class="col-form-label">Welche Kapazität hat das Regal:</label>
                    <input type="number"
                           class="form-control"
                           id="add_capacity"
                           name="capacity"
                           min="401"
                           max="3999"
                           placeholder="Bücheranzahl - Mehr als 400, weniger als 4000."
                           required>
                </div>

                <!-- Submit and Return Button -->
                <button type="submit" class="btn btn-primary" title="Regal hinzufügen">Regal hinzufügen</button>
                <a class="btn btn-secondary" href="index.php?site=buchlager-detail&bookstoreid=<?php echo $bookstoreID; ?>" title="Zurück zum Buchlager">
                    Zurück
                </a>
            </form>
        </div>
    </body>
</html>