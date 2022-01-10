<!DOCTYPE html>
<html lang="de">
    <head>
        <title>Bahoe Books - Autor:innen</title>
    </head>

    <body>
        <div class="container">
            <h1 class="mb-4">Autor:innen</h1>
            <?php
                include_once 'func/class/AuthorHandler.php';

                $authorHandler = new AuthorHandler();
                $authors = $authorHandler->getAllAuthorsSortedByName();

                $alphArray = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");
                $count = 0;

                $letter = strtoupper(substr($authors[$count]['AU_NACHNAME'], 0, 1));

                foreach($authors as $author) :
                    if($count != 0 && substr($authors[$count - 1]['AU_NACHNAME'], 0, 1) != substr($author['AU_NACHNAME'], 0, 1)) {
                        $letter = strtoupper(substr($author['AU_NACHNAME'], 0, 1));
                        echo "<h2>{$letter}</h2>";
                    }
                    else if($count == 0) {
                        echo "<h2>{$letter}</h2>";
                    }
            ?>
                    <p>
                        <a href="index.php?site=autor-detail&autorid=<?php echo htmlentities($author['AUTOR_ID']); ?>"
                            class="link-dark"
                            title="Details zu <?php echo $author['AU_VORNAME'] . " " . $author['AU_NACHNAME']; ?>">
                                <?php echo $author['AU_NACHNAME'] . ", " . $author['AU_VORNAME']; ?>
                        </a>
                    </p>
            <?php
                    ++$count;
                endforeach;
            ?>
        </div>
    </body>
</html>