<?php
    /*
     * Validation and assignment of url input to handle the content and site navigation.
     * First it converts potential injects to html entities. It checks if the url input
     * (the name of the hyperlink / site) is in the array 'siteCodes'. If so, then it will assign
     * the direction of the given site / file to the variable 'content' and it returns to index.php
     * where it will be shown in the proper div / box.
     */
    function validateUrlInput() {
        $content = "";
        $clean = array();

        $siteCodes = array(null, "buecher", "authors");
        $site = isset($_GET['site']) ? htmlentities($_GET['site']) : null;

        if(!in_array($site, $siteCodes)) {
            include_once 'error/notallowed.html';
            exit;
        }
        else {
            $clean['site'] = $site;
        }

        switch($clean['site']) {
            case "buecher":
                $content = "content/books/books.php";
                break;
            case "authors":
                $content = "content/authors/author.php";
                break;
            default:
                $content = "content/home.php";
                break;
        }


        return $content;
    }