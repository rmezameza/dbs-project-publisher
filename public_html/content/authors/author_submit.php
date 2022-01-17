<!DOCTYPE html>
<html lang="de">
    <header>
        <title>Bahoe Boooks</title>
    </header>

    <body>
        <?php
            include_once 'func/class/AutorHandler.php';
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
        ?>
        <a class="btn btn-secondary" href="index.php?site=<?php
                                                                if($op = "delete") {
                                                                    echo "autor" . " title='Zurück zu Autor:innen'";
                                                                }
                                                                else if($op = "autoredit") {
                                                                    echo "autor-deatil&{$authorID}" . " title=Zurück zu {$authorName}";
                                                                }
                                                           ?>">
            Zurück
        </a>
    </body>
</html>
