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
            return $this->databaseHelper->sqlProcedureOneInputOutput("procedure_concatenate_author_name", $authorID);
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

        public function addAuthor($authorArray) : bool{
            $tableName = "autor";
            $affectedColumns = "";
            $values = "";

            if(!$this->checkAuthorArrayEmpty($authorArray)) {
                return false;
            }

            foreach($authorArray as $columnName => $value) {
                if($columnName == "au_vorname") {
                    if($value != "") {
                        $affectedColumns .= $columnName;
                        $values .= "'$value'";
                    }
                }
                else {
                    if ($value != "") {
                        $affectedColumns .= (($affectedColumns == "") ? "{$columnName}" : ", {$columnName}");
                        $values .= (($values == "") ? "'{$value}'" : ", '{$value}'");
                    }
                }
            }

            return $this->databaseHelper->sqlAddData($tableName, $affectedColumns, $values);
        }

        public function editAuthor($authorID, $authorArray) : bool {
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

        public function getBooksNotFromAuthor($bookIDs) {
            $tableName = "buch";
            $columns = "isbn, buch_id, titel";
            $condition = "";
            $order = " titel ASC";

            for($i = 0; $i < count($bookIDs); ++$i) {
                if($i == 0) {
                    $condition = "buch_id != {$bookIDs[$i]}";
                }
                else {
                    $condition .= " AND buch_id != {$bookIDs[$i]}";
                }
            }

            return $this->databaseHelper->sqlGetData($columns, $tableName, $condition, $order);
        }

        public function assignBook($authorID, $bookID) : bool {
            $tableName = "schreibt";
            $affectedColumns = "autor_id, buch_id";
            $values = "{$authorID}, {$bookID}";


            return $this->databaseHelper->sqlAddData($tableName, $affectedColumns, $values);
        }

        public function deleteBookFromAuthor($authorID, $bookID) : bool {
            $tableName = "schreibt";
            $condition = "autor_id = {$authorID} AND buch_id = {$bookID}";

            return $this->databaseHelper->sqlDeleteData($tableName, $condition);
        }
    }