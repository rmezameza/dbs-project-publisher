<!DOCTYPE html>
<html lang="de">
    <head>
        <title>Bahoe Books - Daten abschicken</title>
    </head>
    <body>
        <?php
            require_once 'func/class/BuchHandler.php';
            require_once 'func/inc/book.inc.php';
            require_once 'func/inc/sec.inc.php';

            $bookHandler = new BookHandler();

            // Include url parameter for handling the difference between
            // the creation and the update of a request.
            $site = validateSitesForSubmit();
            $buchID = $prev = $bookType = "";

            if($site == "buchedit") {
                $buchID = isset($_GET['bookid']) ? htmlentities($_GET['bookid']) : null;

                if($buchID == null) {
                    include_once 'error/not_allowed.html';
                    exit;
                }

                $bookType = validateBookType();
                $prev = previousSite();
            }

        $bookArray = array(
            "isbn" => "",
            "title" => "",
            "description" => "",
            "cover" => "",
            "genre" => "",
            "nrOfPages" => -1,
            "price" => -1,
            "releaseYear" => -1,
            "noveltyStatus" => -1
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
                    $bookArray["title"] = sanitizeInput($_POST['title']);
                }

                if(isset($_POST['description'])) {
                    $bookArray["description"] = sanitizeInput($_POST['description']);
                }

                if(isset($_POST['cover'])) {
                    $bookArray["coverImage"] = sanitizeInput($_POST['cover']);
                }

                if(isset($_POST['genre'])) {
                    $bookArray["genre"] = sanitizeInput($_POST['genre']);
                }

                if(!is_string($_POST['nr_of_pages'])) {
                    $bookArray["nrOfPages"] = $_POST['nr_of_pages'];
                }

                if(!is_string($_POST['price'])) {
                    $bookArray["price"] = $_POST['price'];
                }

                if(!is_string($_POST['release_year'])) {
                    $bookArray["releaseYear"] = $_POST['release_year'];
                }

                if(!is_string($_POST['novelty_status'])) {
                    $bookArray["noveltyStatus"] = $_POST['novelty_status'];
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
                case "neues-buch":
                    break;
            }


        ?>
    </body>
</html>