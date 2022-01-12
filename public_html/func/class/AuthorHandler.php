<?php
    include_once 'DatabaseHelper.php';

    class AuthorHandler
    {
        private $databaseHelper;

        public function __construct()
        {
            $this->databaseHelper = new DatabaseHelper();
        }

        public function getAllAuthorsSortedByName($condition)
        {
            $tableName = "view_authors_sorted_by_surname";
            $affectedColumn = "*";
            $order = "au_nachname ASC";

            return $this->databaseHelper->sqlGetData($affectedColumn, $tableName, $condition, $order);
        }

        public function getBooksForSpecificAuthor($authorID)
        {
            $tableName = "view_autor_information";
            $columnNames = "*";
            $condition = "autor_id = {$authorID}";

            return $this->databaseHelper->sqlGetData($columnNames, $tableName, $condition, null);
        }
    }