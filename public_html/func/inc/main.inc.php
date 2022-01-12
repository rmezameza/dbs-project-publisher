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

        $siteCodes = array(null, "buecher", "buchdetail", "neues-buch",
                            "buch-absenden", "buchedit", "autoren", "autor-detail", "buchlager", "buchlager-detail");
        $site = isset($_GET['site']) ? htmlentities($_GET['site']) : null;

        if(!in_array($site, $siteCodes)) {
            include_once 'error/not_allowed.html';
            exit;
        }
        else {
            $clean['site'] = $site;
        }

        switch($clean['site']) {
            case "buecher":
                $content = "content/books/books.php";
                break;
            case "buchdetail":
                $content = "content/books/book_detail.php";
                break;
            case "neues-buch":
                $content = "content/books/book_create.php";
                break;
            case "buchedit":
                $content = "content/books/book_edit.php";
                break;
            case "buch-absenden":
                $content = "content/books/book_submit.php";
                break;
            case "autoren":
                $content = "content/authors/authors.php";
                break;
            case "autor-detail":
                $content = "content/authors/author_detail.php";
                break;
            case "buchlager":
                $content = "content/bookstores/book_stores.php";
                break;
            case "buchlager-detail":
                $content = "content/bookstores/bookstore_detail.php";
                break;
            default:
                $content = "content/home.php";
                break;
        }


        return $content;
    }