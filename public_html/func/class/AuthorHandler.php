<?php
include_once 'DatabaseHelper.php';

class AuthorHandler
{
    private $databaseHelper;

    public function __construct() {
        $this->databaseHelper = new DatabaseHelper();
    }

    public function getAllAuthorsSortedByName() {
        $tableName = "view_authors_sorted_by_surname";
        $affectedColumn = "*";

        return $this->databaseHelper->sqlGetData($affectedColumn, $tableName, null, null);
    }
}