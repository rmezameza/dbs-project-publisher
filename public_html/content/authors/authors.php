<!DOCTYPE html>
<html lang="de">
    <head>
        <title>Bahoe Books - Autor:innen</title>
    </head>

    <body>
        <div class="container">
            <h1>Autor:innen</h1>
            <h2 class="mb-4">Nach Nachnamen sortiert</h2>
            <?php
                include_once 'func/class/AuthorHandler.php';

                $authorHandler = new AuthorHandler();
                $authors = $authorHandler->getAllAuthorsSortedByName(null);

                $count = 0;

                $letter = strtoupper(substr($authors[$count]['AU_NACHNAME'], 0, 1));

                foreach($authors as $author) :
                    $fullName = $authorHandler->fullAuthorName($author['AUTOR_ID']);


                    if($count != 0 && substr($authors[$count - 1]['AU_NACHNAME'], 0, 1) != substr($author['AU_NACHNAME'], 0, 1)) {
                        $letter = (count($author['AU_NACHNAME']) != 0) ? strtoupper(substr($author['AU_NACHNAME'], 0, 1)) : "-";
                        echo "<h2>{$letter}</h2>";
                    }
                    else if($count == 0) {
                        echo "<h2>{$letter}</h2>";
                    }


            ?>
                    <p>
                        <a href="index.php?site=autor-detail&autorid=<?php echo htmlentities($author['AUTOR_ID']); ?>"
                            class="link-dark"
                            title="Details zu <?php echo $fullName; ?>">
                                <?php if(!is_null($author['AU_NACHNAME'])) {
                                    echo $author['AU_NACHNAME'] . ", ";
                                }
                                echo $author['AU_VORNAME']; ?>
                        </a>
                    </p>
            <?php
                    ++$count;
                endforeach;
            ?>
            </div>
        </div>
    </body>
</html>