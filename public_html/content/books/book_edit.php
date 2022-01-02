<!DOCTYPE html>
<html lang="de">
    <head>
        <meta charset="UTF-8">
        <title>Bahoe Book - Buch bearbeiten</title>
    </head>

    <body>
        <?php
            require_once 'func/class/BookHandler.php';
            require_once 'func/inc/book.inc.php';

            $bookHandler = new BookHandler();
            $bookID = isset($_GET['buchid']) ? htmlentities($_GET['buchid']) : null;

            if($bookID == null || !is_numeric($bookID)) {
                include_once 'error/not_allowed.php';
                exit;
            }

            $previousSiteName = previousSite();
            $bookArray = $bookHandler->getSpecificBook($bookID);

            foreach($bookArray as $book) :
        ?>
            <div class="container">
                <h1>Buch bearbeiten:</h1>
                <div class="row text-center">
                    <div class="col">
                        <p>
                            <img class="img-fluid"
                                 src="img/book_covers/<?php echo $book['COVER']; ?>"
                                 alt="Buch Cover"
                                 width="30%">
                        </p>
                        <h2><?php echo $book['TITEL']; ?></h2>
                    </div>
                </div>



                <!-- Form for editing a book. It will contain the actual data for overview. -->
                <form method="post"
                      action="index.php?site=buch-absenden&prev=buchedit&buchid=<?php echo $book['BUCH_ID']; ?>"
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

                    <!-- Change cover filename -->
                    <div class="mb-3">
                        <label for="change_cover_name" class="col-form-label">Name des Covers (inkl. Dateiformat):</label>
                        <input type="text"
                               class="form-control"
                               id="change_cover_name"
                               name="cover"
                               maxlength="110"
                               placeholder="<?php echo $book['COVER']; ?>"
                    </div>

                    <!-- Change total number of pages -->
                    <div class="mb-3">
                        <label for="change_number_of_pages" class="col-form-label">Seitenanzahl:</label>
                        <input type="number"
                               class="form-control"
                               id="change_number_of_pages"
                               name="nr_of_pages"
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
                    <div class="mb-3">
                        <label for="change_genre" class="col-form-label">Genre:</label>
                        <input type="text"
                               class="form-control"
                               id="change_genre"
                               name="genre"
                               placeholder="<?php echo $book['GENRE']; ?>">
                    </div>

                    <!-- Change novelty status -->
                    <div class="mb-3">
                        <p class="pt-2">Neuerscheinung</p>
                        <div class="form-check">
                            <?php
                                $checkNoveltyStatus = false;

                                if($book['NEU_ERSCH'] > 0) {
                                    $checkNoveltyStatus = true;
                                }
                            ?>
                            <input class="form-check-input" type="radio" name="novelty_status"
                                   id="change_novelty_status_yes" <?php if($checkNoveltyStatus) { echo "checked"; } ?>>
                            <label class="form-check-label" for="change_novelty_status_yes">
                                Ja
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="novelty_status"
                                   id="change_novelty_status_no" <?php if(!$checkNoveltyStatus) { echo "checked"; } ?>>
                            <label class="form-check-label" for="change_novelty_status_no">
                                Nein
                            </label>
                        </div>
                    </div>

                    <!-- Change book description -->
                    <div class="mb-3">
                        <label for="change_book_description" class="col-form-label">Kurz Beschreibung:</label>
                        <textarea class="form-control"
                                  id="change_book_description"
                                  name="description"
                                  placeholder="<?php echo $book['KURZ_BESCHR']; ?>"
                                  style="height: 100px;"></textarea>
                    </div>

                    <!-- Submit and Return Button -->
                    <button type="submit" class="btn btn-primary" title="Buch bearbeiten">Buch bearbeiten</button>
                    <a class="btn btn-secondary"
                       href="index.php?site=<?php
                                                echo $previousSiteName;
                                                if($previousSiteName != "buecher") {
                                                    echo "&buchid={$bookID}";
                                                }
                                                else {
                                                    $bookType = validateBookType();
                                                    echo "&type=" . $bookType["shortname"];
                                                }
                                            ?>"
                        title="Zurück">
                        Zurück
                    </a>
                </form>
            </div>
        <?php endforeach; ?>
    </body>
</html>
