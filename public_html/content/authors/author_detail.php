<!DOCTYPE html>
<html lang="de">
    <head>
        <title>Bahoe Books - Detail zum/r Autor:in</title>
    </head>

    <body>
        <?php
            include_once 'func/class/AuthorHandler.php';

            $authorHandler = new AuthorHandler();
            $authorID = isset($_GET['authorid']) ? htmlentities($_GET['authorid']) : null;

            if($authorID == null) {
                include_once 'error/not_allowed.html';
                exit;
            }

            
        ?>
    </body>
</html>
