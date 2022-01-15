<?php
    include_once 'func/class/DatabaseHelper.php';

    class BookstoreHandler
    {
        private $databaseHelper;

        public function __construct() {
            $this->databaseHelper = new DatabaseHelper();
        }

        public function getBookstoreAndCapacity($condition) {
            $tableName = "view_book_store_capacity_status";
            $columnName = "*";

            return $this->databaseHelper->sqlGetData($columnName, $tableName, $condition, null);
        }

        public function getRackID($bookGenre, $bookstoreID) {
            return $this->databaseHelper->sqlProcedureTwoInputOneOutput("procedure_find_genre", $bookGenre, $bookstoreID);
        }

        public function getRackCapacity($rackID, $bookstoreID) {
            return $this->databaseHelper->sqlProcedureTwoInputOneOutput("procedure_take_rack_capacity", $rackID, $bookstoreID);
        }

        public function getSumBooksForSpecificRack($bookstoreID, $rackID) {
            $tableName = "view_sum_books_per_rack";
            $columnName = "*";
            $conditions = "lag_id = {$bookstoreID} AND regal_nr = {$rackID}";

            return $this->databaseHelper->sqlGetData($columnName, $tableName, $conditions, null);
        }

        public function updateAmountOfBooksInRack($bookID, $rackID, $bookstoreID, $numberOfBooks) : bool {
            $affectedColumn = "stueck = {$numberOfBooks}";
            $tableName = "gelagert";
            $conditions = "buch_id = {$bookID} AND regal_nr = {$rackID} AND lag_id = {$bookstoreID}";

            return $this->databaseHelper->sqlEditData($tableName, $affectedColumn, $conditions);
        }

        public function deleteBookInRack($bookID, $rackID, $bookstoreID) : bool {
            $tableName = "gelagert";
            $condition = "buch_id = {$bookID} AND regal_nr = {$rackID} AND lag_id = {$bookstoreID}";

            return $this->databaseHelper->sqlDeleteData($tableName, $condition);
        }

        public function addBookToRack($bookID, $rackID, $bookstoreID, $numberOfBooks) : bool {
            $tableName = "gelagert";
            $affectedColumns = "buch_id, regal_nr, lag_id, stueck";
            $values = "{$bookID}, {$rackID}, {$bookstoreID}, {$numberOfBooks}";

            return $this->databaseHelper->sqlAddData($tableName, $affectedColumns, $values);
        }

        public function checkIfBookInRack($bookID, $rackID, $bookstoreID) {
            $tableName = "gelagert";
            $columnName = "*";
            $conditions = "buch_id = {$bookID} AND regal_nr = {$rackID} AND lag_id = {$bookstoreID}";

            return $this->databaseHelper->sqlGetData($columnName, $tableName, $conditions, null);
        }

        public function checkGenreExistInBookstore($bookstoreID, $genre) {
            $tableName = "regal";
            $columnName = "*";
            $conditions = "lag_id = {$bookstoreID} AND regal_name = '{$genre}'";

            return $this->databaseHelper->sqlGetData($columnName, $tableName, $conditions, null);
        }
    }