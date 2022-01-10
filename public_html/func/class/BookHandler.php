<?php
include_once 'DatabaseHelper.php';

class BookHandler
{
    private $databaseHelper;

    public function __construct() {
        $this->databaseHelper= new DatabaseHelper();
    }

    // Get all books of a specific type (genre / novelty)
    public function getAllBooks($type, $order) {
        $columnNames = "*";
        $tableName = "buch";

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
                $condition = "";
                break;
        }

        return $this->databaseHelper->sqlGetData($columnNames, $tableName, $condition, $order);
    }

    public function getSpecificBook($bookID) {
        $columnName = "*";
        $tableName = "buch";
        $condition = "buch_id = {$bookID}";

        return $this->databaseHelper->sqlGetData($columnName, $tableName, $condition, null);
    }

    public function getAuthorsForBook($bookID) {
        $columnName = "*";
        $tableName = "view_authors_for_book";
        $condition = "buch_id = {$bookID}";

        return $this->databaseHelper->sqlGetData($columnName, $tableName, $condition, null);
    }

    public function editBook($buchID, $bookArray) : bool {
        $tableName = "buch";
        $affectedColumns = "";
        $condition = "buch_id = {$buchID}";

        if(!$this->checkBookArrayEmpty($bookArray)) {
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

    public function addBook($bookArray) : bool {
        $tableName = "buch";
        $affectedColumns = "";
        $values = "";

        if(!$this->checkBookArrayEmpty($bookArray)) {
            return false;
        }

        foreach($bookArray as $columnName => $value) {
            if($columnName == "isbn") {
                if($value != "") {
                    $affectedColumns .= $columnName;
                    $values .= $value;
                }
            }

            if($value != "" && $value != -1) {
                $affectedColumns .= (($affectedColumns == "") ? "{$columnName}" : ", {$columnName}");
                if(is_string($value)) {
                    $values .= (($values == "") ? "'{$value}'" : ", '{$value}'");
                }
                else {
                    $values .= (($values == "") ? "{$value}" : ", {$value}");
                }
            }
        }

        return $this->databaseHelper->sqlAddData($tableName, $affectedColumns, $values);
    }

    private function checkBookArrayEmpty($bookArray) : bool {
        foreach($bookArray as $key => $val) {
            if($val == "" || $val == -1) {
                ++$count;
            }
        }

        if($count == count($bookArray)) {
            return false;
        }

        return true;
    }

    public function deleteBook($bookID) : bool {
        $tableName = "buch";
        $condition = "buch_id = {$bookID}";

        return $this->databaseHelper->sqlDeleteData($tableName, $condition);
    }
}