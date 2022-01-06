<!DOCTYPE html>
<html lang="de">
    <head>
        <title>Bahoe Books - Daten abschicken</title>
    </head>
    <body>
        <?php
            require_once 'func/class/BookHandler.php';
            require_once 'func/inc/book.inc.php';
            require_once 'func/inc/sec.inc.php';

            $bookHandler = new BookHandler();

            // Include url parameter for handling the difference between
            // the creation and the update of a request.
            $site = validateSitesForSubmit();
            $buchID = $prev = $bookType = "";

            if($site == "buchedit") {
                $buchID = isset($_GET['buchid']) ? htmlentities($_GET['buchid']) : null;

                if($buchID == null) {
                    include_once 'error/not_allowed.html';
                    exit;
                }

                $bookType = validateBookType();
                $prev = previousSite();
            }

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
            $nrOfPages = $price = $releaseYear = $noveltyStatus = -1;
            $isbn = $title = $description = $coverImage = $genre = "";

            if($_SERVER['REQUEST_METHOD'] == "POST") {
                if(isset($_POST['isbn'])) {
                    $bookArray["isbn"] = sanitizeInput($_POST['isbn']);
                }

                if(isset($_POST['title'])) {
                    $bookArray["titel"] = sanitizeInput($_POST['title']);
                }

                if(isset($_POST['description'])) {
                    $bookArray["kurz_beschr"] = sanitizeInput($_POST['description']);
                }

                if(isset($_POST['cover'])) {
                    $bookArray["cover"] = sanitizeInput($_POST['cover']);
                }

                if(isset($_POST['genre'])) {
                    $bookArray["genre"] = sanitizeInput($_POST['genre']);
                }

                if(isset($_POST['nr_of_pages'])) {
                    $bookArray["seiten_anz"] = (int) sanitizeInput($_POST['nr_of_pages']);
                }

                if(isset($_POST['price'])) {
                    $bookArray["seiten_anz"] = (int) sanitizeInput($_POST['price']);
                }

                if(isset($_POST['release_year'])) {
                    $bookArray["seiten_anz"] = (int) sanitizeInput($_POST['release_year']);
                }

                if(isset($_POST['novelty_status'])) {
                    $bookArray["seiten_anz"] = (int) sanitizeInput($_POST['novelty_status']);
                }

            }



            switch($site) {
                case "buchedit":
                    if($bookHandler->editBook($buchID, $bookArray)) {
                        echo "<h1>Geschafft!</h1>";
                        echo "<h2>Das Buch wurde erfolgreich bearbeitet.</h2>";
                    }
                    else {
                        echo "<h1>Fehler!</h1>";
                        echo "<h2>Das Buch wurde leider nicht bearbeitet.</h2>";
                    }
                    
                    break;
            }


        ?>
    </body>
</html>