<!DOCTYPE html>
<html lang="de">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="css/bootstrap/bootstrap.min.css">
        <title>Bahoe Books - Home</title>
    </head>

    <body>
        <!-- Header section -->
        <div id="header" class="container pt-3 pb-3">
            <?php
                include_once 'content/header.html';
            ?>
        </div>

        <!-- Navigation section -->
        <div id="navigation" class="container pt-5">
            <?php
                include_once 'content/navigation.html';
            ?>
        </div>

        <!-- Content section -->
        <div id="content" class="container pt-5">
            <?php
            // Include main mechanic for website which checks
            // id in url for specific content and clears url input
            include_once 'func/inc/main.inc.php';
            include_once (validateUrlInput());
            ?>
        </div>
        <script src="jquery-3.6.0.js"></script>
        <script src="js/bootstrap/bootstrap.bundle.js"></script>
    </body>

</html>
