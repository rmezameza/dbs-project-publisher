<?php
include_once 'DatabaseHelper.php';

class BookHandler
{
    private $databaseHelper;

    public function __construct() {
        $this->databaseHelper= new DatabaseHelper();
    }

    // Get all books of a specific type (genre / novelty)
    public function getAllBooks($type) {
        $columnNames = "*";
        $tableName = "buch";
        $condition = "";

        switch($type) {
            case "neu":
                $condition = "neu_ersch > 0";
                break;
            case "politics":
                $condition = "genre = 'politics'";
                break;
            case "literature":
                $condition = "genre = 'literature'";
                break;
            case "history":
                $condition = "genre = 'history'";
                break;
            case "theory":
                $condition = "genre = 'theory'";
                break;
            case "comics":
                $condition = "genre = 'comics'";
                break;
            case "art-books":
                $condition = "genre = 'artbooks'";
                break;
            case "kids":
                $condition = "genre = 'kids'";
                break;
            default:
                $condition = null;
                break;
        }

        return $this->databaseHelper->sqlGetData($columnNames, $tableName, $condition);
    }

    public function getSpecificBook($bookID) {
        $columnName = "*";
        $tableName = "buch";
        $condition = "buch_id = {$bookID}";

        return $this->databaseHelper->sqlGetData($columnName, $tableName, $condition);
    }

    public function getAuthorsForBook($bookID) {
        $columnName = "*";
        $tableName = "view_authors_for_book";
        $condition = "buch_id = {$bookID}";

        return $this->databaseHelper->sqlGetData($columnName, $tableName, $condition);
    }

    public function editBook($buchID, $bookArray) : bool {
        $tableName = "buch";
        $affectedColumns = "";
        $condition = "buch_id = {$buchID}";
        $count = 0;

        foreach($bookArray as $key => $val) {
            if($val == "" || $val == -1 ) {
                ++$count;
            }
        }

        if($count == count($bookArray)) {
            return false;
        }

        foreach($bookArray as $columName => $value) {
            if($columName == "isbn") {
                if ($bookArray['isbn'] != "") {
                    $affectedColumns .= "isbn = {$bookArray['isbn']}";
                }
                continue;
            }

            if($value != "" && $value != -1) {
                $affectedColumns .= (($affectedColumns == "") ? "{$columName}" : ", {$columName}") . " = {$value}";
            }

        }

        return $this->databaseHelper->sqlEditData($tableName, $affectedColumns, $condition);
    }
}