<?php
    require_once 'PasswordHandler.php';

    class DatabaseHelper
    {
        private $passwordHandler;

        // Since we need only one connection object, it can be stored in a member variable.
        // $conn is set in the constructor.
        protected $conn;

        // Create connection in the constructor
        public function __construct()
        {
            $this->passwordHandler = new PasswordHandler();

            try {
                // Create connection with the command oci_connect(String(username), String(password), String(connection_string))
                // The @ sign avoids the output of warnings
                // It could be helpful to use the function without the @ symbol during developing process
                $this->conn = @oci_connect(
                    $this->passwordHandler->getUsername(),
                    $this->passwordHandler->getPassword(),
                    $this->passwordHandler->getConnection()
                );

                //check if the connection object is != null
                if (!$this->conn) {
                    // die(String(message)): stop PHP script and output message:
                    die("DB error: Connection can't be established!");
                }

            } catch (Exception $e) {
                die("DB error: {$e->getMessage()}");
            }
        }

        // Used to clean up
        public function __destruct()
        {
            // clean up
            @oci_close($this->conn);
        }


        public function sqlGetData($columnNames, $tableName, $conditions, $order) {
            $res = null;
            $sql = "SELECT {$columnNames} FROM {$tableName}";

            if($conditions) {
                $sql .= " WHERE {$conditions}";
            }

            if($order) {
                $sql .= " ORDER BY {$order}";
            }

            $statement = oci_parse($this->conn, $sql);

            oci_execute($statement);
            oci_fetch_all($statement, $res, 0, 0, OCI_FETCHSTATEMENT_BY_ROW);
            oci_free_statement($statement);

            return $res;
        }

        public function sqlEditData($tableName, $affectedColumns, $condition) : bool {
            $sql = "UPDATE {$tableName} SET {$affectedColumns} WHERE {$condition}";
            $statement = oci_parse($this->conn, $sql);

            $result = oci_execute($statement) && oci_commit($this->conn);
            oci_free_statement($statement);

            return $result;
        }

        public function sqlAddData($tableName, $affectedColumns, $values) : bool {
            $sql = "INSERT INTO {$tableName} ({$affectedColumns}) VALUES ({$values})";
            $statement = oci_parse($this->conn, $sql);

            $result = oci_execute($statement) && oci_commit($this->conn);
            oci_free_statement($statement);

            return $result;
        }

        public function sqlDeleteData($tableName, $condition) : bool {
            $sql = "DELETE FROM {$tableName} WHERE {$condition}";
            $statement = oci_parse($this->conn, $sql);

            $result = oci_execute($statement) && oci_commit($this->conn);
            oci_free_statement($statement);

            return $result;
        }

        public function sqlProcedureOneInputOutput($procedureName, $inputData) {
            $sql = "BEGIN {$procedureName}(:input_data, :output_data); END;";
            $statement = oci_parse($this->conn, $sql);

            oci_bind_by_name($statement, ':input_data', $inputData, 100);
            oci_bind_by_name($statement, ':output_data', $outputData, 100);

            oci_execute($statement);

            return $outputData;
        }

        public function sqlProcedureTwoInputOneOutput($procedureName, $inputDataOne, $inputDataTwo) {
            $sql = "BEGIN {$procedureName}(:input_data_one, :input_data_two, :output_data); END;";
            $statement = oci_parse($this->conn, $sql);

            oci_bind_by_name($statement, ':input_data_one', $inputDataOne, 100);
            oci_bind_by_name($statement, 'input_data_two', $inputDataTwo, 100);
            oci_bind_by_name($statement, ':output_data', $outputData, 100);

            oci_execute($statement);

            return $outputData;
        }
    }