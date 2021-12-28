<?php

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


        public function getEntries($columnNames, $tableName, $conditions) {
            $res = "";
            $sql = "SELECT {$columnNames} FROM {$tableName}";

            if($conditions) {
                $sql .= " WHERE {$conditions}";
            }

            $statement = oci_parse($this->conn, $sql);

            oci_execute($statement);
            oci_fetch_all($statement, $res, 0, 0, OCI_FETCHSTATEMENT_BY_ROW);
            oci_free_statement($statement);

            return $res;
        }


    }