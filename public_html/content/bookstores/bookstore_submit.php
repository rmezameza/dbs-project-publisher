<!DOCTYPE html>
<html lang="de">
    <head>
        <title>Bahoe Books</title>
    </head>

    <body>
        <div class="container">
            <?php
            include_once 'func/class/BookstoreHandler.php';
            include_once 'func/inc/sec.inc.php';
            include_once 'func/inc/bookstore.inc.php';

            $bookstoreHandler = new BookstoreHandler();

            $bookstoreID = isset($_GET['bookstoreid']) ? htmlentities($_GET['bookstoreid']) : null;
            $op = isset($_GET['op']) ? htmlentities($_GET['op']) : null;
            $objectName = "";
            $objectOperation = "";
            $checkSubmit = true;

            if(is_null($bookstoreID) && is_null($op)) {
                include 'error/not_allowed.html';
                exit;
            }

            switch($op) {
                case "buchlager-loeschen":
                    $objectName = "Buchlager";
                    $objectOperation = "gelöscht";
                    $checkSubmit = $bookstoreHandler->deleteBookstoreOrRack($bookstoreID, null);
                    break;
                case "regal-loeschen":
                    $rackID = isset($_GET['regalnr']) ? htmlentities($_GET['regalnr']) : null;
                    checkInputValueForNull($rackID);
                    $objectName = "Regal";
                    $objectOperation = "gelöscht";
                    $checkSubmit = $bookstoreHandler->deleteBookstoreOrRack($bookstoreID, $rackID);
                    break;
                case "neues-regal":
                    $objectName = "Regal";
                    $objectOperation = "hinzugefügt";
                    $newRackArray = array();
                    $newRackArray['LAG_ID'] = $bookstoreID;

                    if($_SERVER['REQUEST_METHOD'] == "POST") {
                        if(isset($_POST['genre'])) {
                            $newRackArray['REGAL_NAME'] = sanitizeInput($_POST['genre']);
                        }

                        if(isset($_POST['capacity'])) {
                            $newRackArray['REGAL_KAPAZITAET'] = (int)sanitizeInput($_POST['capacity']);
                        }
                    }

                    $checkSubmit = $bookstoreHandler->addRackToBookstore($newRackArray);
                    break;
                case "buchlager-edit":
                    $objectName = "Buchlager";
                    $objectOperation = "bearbeitet";
                    $bookstoreArray = checkPostRequest();

                    /*
                    if($_SERVER['REQUEST_METHOD'] == "POST") {
                        if(isset($_POST['street'])) {
                            $bookstoreArray['LAG_STRASSE'] = sanitizeInput($_POST['street']);
                        }

                        if(isset($_POST['zip'])) {
                            $bookstoreArray['LAG_PLZ'] = sanitizeInput($_POST['zip']);
                        }

                        if(isset($_POST['place'])) {
                            $bookstoreArray['LAG_ORT'] = sanitizeInput($_POST['place']);
                        }

                        if(isset($_POST['country'])) {
                            $bookstoreArray['LAG_LAND'] = sanitizeInput($_POST['country']);
                        }
                    }*/

                    $bookstoreArray['LAG_ID'] = $bookstoreID;

                    $checkSubmit = $bookstoreHandler->editBookstore($bookstoreArray);
                    break;
                case "neues-buchlager":
                    $objectName = "Buchlager";
                    $objectOperation = "hinzugefügt";
                    $bookstoreArray = checkPostRequest();

                    /*
                    if($_SERVER['REQUEST_METHOD'] == "POST") {
                        if(isset($_POST['street'])) {
                            $bookstoreArray['LAG_STRASSE'] = sanitizeInput($_POST['street']);
                        }

                        if(isset($_POST['zip'])) {
                            $bookstoreArray['LAG_PLZ'] = sanitizeInput($_POST['zip']);
                        }

                        if(isset($_POST['place'])) {
                            $bookstoreArray['LAG_ORT'] = sanitizeInput($_POST['place']);
                        }

                        if(isset($_POST['country'])) {
                            $bookstoreArray['LAG_LAND'] = sanitizeInput($_POST['country']);
                        }
                    }*/
                    $checkSubmit = $bookstoreHandler->addBokstore($bookstoreArray);
                    break;
            }

            ?>
            <?php if($checkSubmit) { ?>
                <h1>Geschafft!</h1>
                <h2>Das <?php echo $objectName; ?> wurde erfolgreich <?php echo $objectOperation; ?>.</h2>
            <?php
                }
                else {
            ?>
                <h1>Fehler!</h1>
                <h2>Das <?php echo $objectName; ?> wurde leider nicht <?php echo $objectOperation; ?>.</h2>
            <?php } ?>

            <a class="btn btn-secondary" <?php
                                            if($op == "buchlager-loeschen" || $op == "neues-buchlager") {
                                                echo " href='index.php?site=buchlager'";
                                                echo " title='Zurück zu den Buchlager'";
                                            }
                                            else { //if($op == "regal-loeschen" || $op == "neues-regal" || $)
                                                echo " href='index.php?site=buchlager-detail&bookstoreid={$bookstoreID}'";
                                                echo " title='Zurück zum Buchlager'";
                                            }
                                        ?>
            >
                Zurück
            </a>

        </div>
    </body>
</html>