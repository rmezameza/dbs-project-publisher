<!DOCTYPE html>
<html lang="de">
    <head>
        <meta charset="UTF-8">
        <title>Bahoe Book - Buchlager bearbeiten</title>
    </head>

    <body>
        <?php
        require_once 'func/class/BookstoreHandler.php';
        require_once 'func/inc/sec.inc.php';

        $bookstoreHandler = new BookstoreHandler();
        $bookstoreID = isset($_GET['bookstoreid']) ? htmlentities($_GET['bookstoreid']) : null;
        checkInputValueForNull($bookstoreID);

        $bookstoreArray = $bookstoreHandler->getSpecificBookstoreOrAll($bookstoreID);

        foreach($bookstoreArray as $bookstore) :
            ?>
            <div class="container">
                <h1>Buchlager bearbeiten:</h1>
                <h2 class="mb-5"><?php echo $bookstore['LAG_STRASSE'] . ", " . $bookstore['LAG_PLZ'] . " " . $bookstore['LAG_ORT']; ?></h2>

                <!-- Form for editing a bookstore. It will contain the actual data for overview. -->
                <form method="post"
                      action="<?php echo "index.php?site=buchlager-submit" .
                          "&op=buchlager-edit" .
                          "&bookstoreid=" . htmlentities($bookstoreID); ?>"
                      class="mb-4">

                    <!-- Change street name -->
                    <div class="mb-3">
                        <label for="change_street" class="col-form-label">Strasse:</label>
                        <input type="text"
                               class="form-control"
                               id="change_street"
                               name="street"
                               maxlength="120"
                               placeholder="<?php echo $bookstore['LAG_STRASSE']; ?>">
                    </div>

                    <!-- Change zip code -->
                    <div class="mb-3">
                        <label for="change_zip" class="col-form-label">Postleitzahl:</label>
                        <input type="text"
                               class="form-control"
                               id="change_zip"
                               name="zip"
                               maxlength="20"
                               placeholder="<?php echo $bookstore['LAG_PLZ']; ?>">
                    </div>

                    <!-- Change place -->
                    <div class="mb-3">
                        <label for="change_place" class="col-form-label">Ort:</label>
                        <input type="text"
                               class="form-control"
                               id="change_place"
                               name="place"
                               maxlength="50"
                               placeholder="<?php echo $bookstore['LAG_ORT']; ?>"
                    </div>

                    <!-- Change country -->
                    <div class="mb-5">
                        <label for="change_country" class="col-form-label">Land:</label>
                        <input type="text"
                               class="form-control"
                               id="change_country"
                               name="country"
                               maxlength="80"
                               placeholder="<?php echo $bookstore['LAG_LAND']; ?>">
                    </div>

                    <!-- Submit and Return Button -->
                    <button type="submit" class="btn btn-primary" title="Buch bearbeiten">Buch bearbeiten</button>
                    <a class="btn btn-secondary"
                       href="index.php?site=buchlager-detail&bookstoreid=<?php echo $bookstoreID; ?>"
                       title="Zurück">
                        Zurück
                    </a>
                </form>
            </div>
        <?php endforeach; ?>
    </body>
</html>
