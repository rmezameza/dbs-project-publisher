<!DOCTYPE html>
<html lang="de">
    <header>
        <title>Bahoe Boooks</title>
    </header>

    <body>
        <?php
            include_once 'func/class/AuthorHandler.php';
            include_once 'func/inc/sec.inc.php';
            $authorHandler = new AuthorHandler();

            $authorID = isset($_GET['autorid']) ? htmlentities($_GET['autorid']) : null;
            $op = isset($_GET['op']) ? htmlentities($_GET['op']) : null;
            $authorName = isset($_GET['autorname']) ? htmlentities($_GET['autorname']) : null;

            if($authorID == null || $op == null || autorname == null) {
                include_once 'error/not_allowed.html';
                exit;
            }

            if($op == "delete") {
                if($authorHandler->deleteAuthor($authorID)) {
                    echo "<h1 class='5-mb'>Erfolg!</h1>";
                    echo "<h2>Der / Die Autor:in '$authorName' wurde erfolgreich gelöscht.</h2>";
                }
                else {
                    echo "<h1 class='5-mb'>Fehler!</h1>";
                    echo "<h2>Der / Die Autor:in '$authorName' wurde leider nicht gelöscht.</h2>";
                }
            }
            else if($op = "autor-detail") {

                $authorArray = array();

                if($_SERVER['REQUEST_METHOD'] == "POST") {
                    if(isset($_POST['forename'])) {
                        $authorArray['forename'] = sanitizeInput($_POST['forename']);
                    }

                    if(isset($_POST['surname'])) {
                        $authorArray['surname'] = sanitizeInput($_POST['surname']);
                    }

                    if(isset($_POST['biography'])) {
                        $authorArray['bio'] = sanitizeInput($_POST['biography']);
                    }
                }

                if($authorHandler->editAuthor($authorID, $authorArray)) {
                    echo "<h1>Geschafft!</h1>";
                    echo "<h2>Der / Die Autor:in '{$authorHandler->fullAuthorName($authorID)}' wurde erfolgreich bearbeitet.</h2>";
                }
                else {
                    echo "<h1>Fehler!</h1>";
                    echo "<h2>Der / Die Autor:in '{$authorHandler->fullAuthorName(($authorID))}' wurde leider nicht bearbeitet.</h2>";
                }
            }
        ?>

        <a class="btn btn-secondary" href="index.php?site=<?php
                                                                if($op == "delete") {
                                                                    echo "autor"; ?>" title="Zurück zu Autor:innen">
                                                                <?php
                                                                }
                                                                else if($op == "autor-detail") {
                                                                    echo "autor-detail&autorid={$authorID}"; ?>" title="Zurück zu <?php echo $authorName; ?>">
                                                                <?php
                                                                }
                                                                ?>
            Zurück
        </a>
    </body>
</html>
