<?php
    include_once 'func/class/DatabaseHelper.php';

    class BookstoreHandler
    {
        private $databaseHelper;

        public function __construct() {
            $this->databaseHelper = new DatabaseHelper();
        }

        public function getAllOrSpecificBookStores($condition) {
            $tableName = "view_book_store_capacity_status";
            $columnName = "*";

            return $this->databaseHelper->sqlGetData($columnName, $tableName, $condition, null);
        }
    }