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
}