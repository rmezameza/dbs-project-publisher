<!DOCTYPE html>
<html lang="de">
    <head>
        <title>Bahoe Books - Daten abschicken</title>
    </head>
    <body>
        <div class="container">
            <?php
                require_once 'func/class/BookHandler.php';
                require_once 'func/inc/book.inc.php';
                require_once 'func/inc/sec.inc.php';

                $bookHandler = new BookHandler();

                // Include url parameter for handling the difference between
                // the creation and the update of a request.
                $site = validateSitesForSubmit();
                $bookID = $prev = $bookType = "";

                if($site == "buchedit" || $site == "buch-loeschen") {
                    $bookID = isset($_GET['buchid']) ? htmlentities($_GET['buchid']) : null;

                    if($bookID == null) {
                        include_once 'error/not_allowed.html';
                        exit;
                    }

                    $bookType = validateBookType();

                    if($site == "buchedit") {
                        $prev = previousSite();
                    }

                }

            if($site != "buch-loeschen") {
                $bookArray = array(
                    "isbn" => "",
                    "titel" => "",
                    "kurz_beschr" => "",
                    "cover" => "",
                    "genre" => "",
                    "seiten_anz" => -1,
                    "preis" => -1,
                    "ersch_jahr" => -1,
                    "neu_ersch" => -1
                );
                // Assign variable for security reasons.
                // Numbers only can be positive, so for control reasons
                // there are assigned with negative numbers.

                if ($_SERVER['REQUEST_METHOD'] == "POST") {
                    if (isset($_POST['isbn'])) {
                        $bookArray["isbn"] = sanitizeInput($_POST['isbn']);
                    }

                    if (isset($_POST['title'])) {
                        $bookArray["titel"] = sanitizeInput($_POST['title']);
                    }

                    if (isset($_POST['description'])) {
                        $bookArray["kurz_beschr"] = sanitizeInput($_POST['description']);
                    }

                    if (isset($_POST['cover'])) {
                        $bookArray["cover"] = sanitizeInput($_POST['cover']);
                    }

                    if (isset($_POST['genre'])) {
                        $bookArray["genre"] = sanitizeInput($_POST['genre']);
                    }

                    if (isset($_POST['nr_of_pages'])) {
                        $bookArray["seiten_anz"] = (int)sanitizeInput($_POST['nr_of_pages']);
                    }

                    if (isset($_POST['price'])) {
                        $bookArray["preis"] = (int)sanitizeInput($_POST['price']);
                    }

                    if (isset($_POST['release_year'])) {
                        $bookArray["ersch_jahr"] = (int)sanitizeInput($_POST['release_year']);
                    }

                    if (isset($_POST['novelty_status'])) {
                        $bookArray["neu_ersch"] = (int)sanitizeInput($_POST['novelty_status']);
                    }

                }
            }


                switch($site) {
                    case "buchedit":
                        if($bookHandler->editBook($bookID, $bookArray)) {
                            echo "<h1>Geschafft!</h1>";
                            echo "<h2>Das Buch wurde erfolgreich bearbeitet.</h2>";
                        }
                        else {
                            echo "<h1>Fehler!</h1>";
                            echo "<h2>Das Buch wurde leider nicht bearbeitet.</h2>";
                        }
                        break;
                    case "neues-buch":
                        if($bookHandler->addBook($bookArray)) {
                            echo "<h1>Geschafft!</h1>";
                            echo "<h2>Das Buch wurde erfolgreich angelegt.</h2>";
                        }
                        else {
                            echo "<h1>Fehler!</h1>";
                            echo "<h2>Das Buch wurde leider nicht angelegt.</h2>";
                        }
                        break;
                    case "buch-loeschen":
                        if($bookHandler->deleteBook($bookID)) {
                            echo "<h1>Geschafft!</h1>";
                            echo "<h2>Das Buch wurde erfolgreich gelöscht.</h2>";
                        }
                        else {
                            echo "<h1>Fehler!</h1>";
                            echo "<h2>Das Buch wurde leider nicht gelöscht.</h2>";
                        }
                }
            ?>
                <a class="btn btn-secondary"
                   <?php
                        if($site == "buchedit") {
                            echo "href='index.php?site={$site}&prev={$prev}&type={$bookType['shortname']}&buchid={$bookID}'";
                            echo "title='Zurück zur Buch-Bearbeitung'";
                        }
                        else if($site == "neues-buch") {
                            echo "href='index.php?site={$site}'";
                            echo "title='Zurück zum Hinzufügen eines Buches'";
                        }
                        else {
                            echo "href='index.php?site=buecher&type={$bookType['shortname']}'";
                            echo "title='Zurück zu {$bookType['longname']}'";
                        }
                   ?>>
                    Zurück
                </a>
        </div>
    </body>
</html>