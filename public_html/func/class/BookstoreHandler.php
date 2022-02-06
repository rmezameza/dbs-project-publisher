<?php
    include_once 'func/class/DatabaseHelper.php';

    class BookstoreHandler
    {
        private $databaseHelper;

        public function __construct() {
            $this->databaseHelper = new DatabaseHelper();
        }

        public function getBookstoreAndCapacity($condition) {
            //$tableName = "view_book_store_capacity_status";
            $tableName = "view_bookstore_joins_vbs_capstatus";
            $columnName = "*";

            return $this->databaseHelper->sqlGetData($columnName, $tableName, $condition, null);
        }

        public function getRackID($bookGenre, $bookstoreID) {
            return $this->databaseHelper->sqlProcedureTwoInputOneOutput("procedure_find_genre", $bookGenre, $bookstoreID);
        }

        public function getOneOrMoreRacks($bookstoreID, $rackID) {
            $tableName = "regal";
            $columnName = "*";
            $condition = (is_null($rackID)) ? "lag_id = {$bookstoreID}" : "lag_id = {$bookstoreID} AND regal_nr = {$rackID}";

            return $this->databaseHelper->sqlGetData($columnName, $tableName, $condition, null);
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

        public function deleteBookstoreOrRack($bookstoreID, $rackID) : bool {
            $tableName = "";
            $condition = "";

            if(is_null($rackID)){
                $tableName = "buchlager";
                $condition = "lag_id = {$bookstoreID}";
            }
            else {
                $tableName = "regal";
                $condition = "regal_nr = {$rackID} AND lag_id = {$bookstoreID}";
            }

            return $this->databaseHelper->sqlDeleteData($tableName, $condition);
        }

        public function addRackToBookstore($newRackArray) : bool {
            $tableName = "regal";
            $affectedColumns = "regal_nr, regal_name, regal_kapazitaet, lag_id";
            $rackIDs = array();
            $newRackID = 0;
            $existingRacks = $this->getOneOrMoreRacks($newRackArray['LAG_ID'], null);

            for($i = 0; $i < count($existingRacks); ++$i) {
                $rackIDs[$i] = $existingRacks[$i]['REGAL_NR'];
            }

            if(count($rackIDs) > 0) {
                $newRackID = max($rackIDs);
                ++$newRackID;
            }
            else {
                ++$newRackID;
            }
            
            $values = "{$newRackID}, '{$newRackArray['REGAL_NAME']}', {$newRackArray['REGAL_KAPAZITAET']}, {$newRackArray['LAG_ID']}";

            return $this->databaseHelper->sqlAddData($tableName, $affectedColumns, $values);
        }

        public function addBokstore($bookstoreArray) : bool {
            $tableName = "buchlager";
            $affectedColumns = "";
            $values = "";

            if(empty($bookstoreArray)) {
                return false;
            }

            foreach($bookstoreArray as $columnName => $value) {
                if($columnName == "LAG_STRASSE") {
                    if($value != "") {
                        $affectedColumns .= $columnName;
                        $values .= "'{$value}'";
                    }
                    continue;
                }

                if($value != "") {
                    $affectedColumns .= (($affectedColumns == "") ? "{$columnName}" : ", {$columnName}");
                    $values .= (($values == "") ? "'{$value}'" : ", '{$value}'");
                }
            }

            return $this->databaseHelper->sqlAddData($tableName, $affectedColumns, $values);
        }

        public function editBookstore($bookstoreArray) : bool {
            $tableName = "buchlager";
            $affectedColumns = "";
            $condition = "lag_id = {$bookstoreArray['LAG_ID']}";

            if(empty($bookstoreArray)) {
                return false;
            }

            foreach($bookstoreArray as $columnName => $value) {
                if($columnName == "LAG_ID") {
                    continue;
                }

                if($columnName == "LAG_STRASSE") {
                    if ($value != "") {
                        $affectedColumns .= "$columnName = '{$value}'";
                    }
                    continue;
                }

                if($value != "") {
                    $affectedColumns .= (($affectedColumns == "") ? "{$columnName}" : ", {$columnName}") . " = '{$value}'";
                }
            }

            return $this->databaseHelper->sqlEditData($tableName, $affectedColumns, $condition);
        }

        public function getSpecificBookstoreOrAll($bookstoreID) {
            $tableName = "buchlager";
            $columnName = "*";

            $condition = (is_null($bookstoreID)) ? null : "lag_id = {$bookstoreID}";

            return $this->databaseHelper->sqlGetData($columnName, $tableName, $condition, null);
        }

    }