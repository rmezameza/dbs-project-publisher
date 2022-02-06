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

            $op = isset($_GET['op']) ? htmlentities($_GET['op']) : null;
            checkInputValueForNull($op);

            if($op != "neuer-autor") {
                $authorID = isset($_GET['autorid']) ? htmlentities($_GET['autorid']) : null;
                checkInputValueForNull($authorID);
            }


            if($op == "delete") {
                $authorName = isset($_GET['autorname']) ? htmlentities($_GET['autorname']) : null;

                if($authorHandler->deleteAuthor($authorID)) {
                    echo "<h1 class='5-mb'>Erfolg!</h1>";
                    echo "<h2>Der / Die Autor:in '$authorName' wurde erfolgreich gelöscht.</h2>";
                }
                else {
                    echo "<h1 class='5-mb'>Fehler!</h1>";
                    echo "<h2>Der / Die Autor:in '$authorName' wurde leider nicht gelöscht.</h2>";
                }
            }
            else if($op == "autor-detail" || $op == "neuer-autor") {
                $authorArray = array();

                if($_SERVER['REQUEST_METHOD'] == "POST") {
                    if(isset($_POST['forename'])) {
                        $authorArray["au_vorname"] = sanitizeInput($_POST['forename']);
                    }

                    if(isset($_POST['surname'])) {
                        $authorArray["au_nachname"] = sanitizeInput($_POST['surname']);
                    }

                    if(isset($_POST["biography"])) {
                        $authorArray['bio'] = sanitizeInput($_POST['biography']);
                    }
                }

                if($op == "autor-detail") {
                    if ($authorHandler->editAuthor($authorID, $authorArray)) {
                        echo "<h1>Geschafft!</h1>";
                        echo "<h2>Der / Die Autor:in '{$authorHandler->fullAuthorName($authorID)}' wurde erfolgreich bearbeitet.</h2>";
                    }
                    else {
                        echo "<h1>Fehler!</h1>";
                        echo "<h2>Der / Die Autor:in '{$authorHandler->fullAuthorName(($authorID))}' wurde leider nicht bearbeitet.</h2>";
                    }
                }

                if($op == "neuer-autor") {
                    if ($authorHandler->addAuthor($authorArray)) {
                        echo "<h1>Geschafft!</h1>";
                        echo "<h2>Der / Die Autor:in '{$authorArray['au_vorname']} {$authorArray['au_nachname']}' wurde erfolgreich hinzugefügt.</h2>";
                    }
                    else {
                        echo "<h1>Fehler!</h1>";
                        echo "<h2>Der / Die Autor:in '{$authorArray['au_vorname']} {$authorArray['au_nachname']}'' wurde leider nicht hinzugefügt.</h2>";
                    }
                }
            }
            else if($op == "buch-loeschen") {
                $bookID = isset($_GET['buchid']) ? htmlentities($_GET['buchid']) : null;
                checkInputValueForNull($bookID);

                if ($authorHandler->deleteBookFromAuthor($authorID, $bookID)) {
                    echo "<h1>Geschafft!</h1>";
                    echo "<h2>Das Buch wurde dem / der Autor:in entfernt.</h2>";
                }
                else {
                    echo "<h1>Fehler!</h1>";
                    echo "<h2>Leider, das Buch bleibt weiterhin der / dem Autor:in zugewiesen.</h2>";
                }
            }
            else if($op == "buch-zuweisung") {
                if($_SERVER['REQUEST_METHOD'] == "POST") {
                    if(isset($_POST['book_id'])) {
                        $bookID = (int)sanitizeInput($_POST['book_id']);
                    }
                }

                if ($authorHandler->assignBook($authorID, $bookID)) {
                    echo "<h1>Geschafft!</h1>";
                    echo "<h2>Das Buch wurde der / dem Autor:in zugewiesen.</h2>";
                }
                else {
                    echo "<h1>Fehler!</h1>";
                    echo "<h2>Leider wurde keine Zuweisung durchgeführt.</h2>";
                }
            }
        ?>

        <a class="btn btn-secondary" href="index.php?site=<?php
                                                                if($op == "delete") {
                                                                    echo "autoren"; ?>" title="Zurück zu Autor:innen">
                                                                <?php
                                                                }
                                                                else if($op == "autor-detail") {
                                                                    echo "autor-detail&autorid={$authorID}"; ?>" title="Zurück zu <?php echo $authorName; ?>">
                                                                <?php
                                                                }
                                                                else if($op == "neuer-autor") {
                                                                    echo "neuer-autor"; ?>" title="Zurück zur Autor:innen Erstellung">
                                                                <?php }
                                                                else if($op == "buch-zuweisung" || $op == "buch-loeschen") {
                                                                    echo "autor-detail&autorid={$authorID}"; ?>" title="Zurück zum/r Autor:in">
                                                                <?php } ?>

            Zurück
        </a>
    </body>
</html>
