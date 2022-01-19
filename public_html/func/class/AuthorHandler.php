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

        public function fullAuthorName($authorID) {
            return $this->databaseHelper->sqlProcedureOneInputOutput("buchautor", $authorID);
        }

        public function deleteAuthor($authorID) : bool {
            $tableName = "autor";
            $condition = "autor_id = {$authorID}";

            return $this->databaseHelper->sqlDeleteData($tableName, $condition);
        }

        public function getSpecificAuthor($authorID) {
            $columnName = "*";
            $tableName = "autor";
            $condition = "autor_id = {$authorID}";

            return $this->databaseHelper->sqlGetData($columnName, $tableName, $condition, null);
        }

        public function editAuthor($authorID, $authorArray) {
            $tableName = "autor";
            $affectedColumns = "";
            $condition = "autor_id = {$authorID}";

            if(!$this->checkAuthorArrayEmpty($authorArray)) {
                return false;
            }

            foreach($authorArray as $columName => $value) {
                if($columName == "forename") {
                    if ($authorArray['forename'] != "") {
                        $affectedColumns .= "author = '{$authorArray['forename']}'";
                    }
                    continue;
                }

                if($value != "") {
                    $affectedColumns .= (($affectedColumns == "") ? "{$columName}" : ", {$columName}") . " = '{$value}'";
                }

            }

            return $this->databaseHelper->sqlEditData($tableName, $affectedColumns, $condition);
        }

        private function checkAuthorArrayEmpty($authorArray) : bool {
            $count = 0;

            foreach($authorArray as $key => $val) {
                if($val == "" || $val == -1) {
                    ++$count;
                }
            }

            if($count == count($authorArray)) {
                return false;
            }

            return true;
        }
    }