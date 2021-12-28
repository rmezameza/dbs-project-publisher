<?php

    class DatabaseHelper
    {
        // Since the connection details are constant, define them as const
        // We can refer to constants like e.g. DatabaseHelper::username
        const username = '------>USERNAME<---'; // use a + your matriculation number
        const password = '------>dbs19<-----'; // use your oracle db password
        const con_string = 'oracle-lab.cs.univie.ac.at:1521/lab';

        // Since we need only one connection object, it can be stored in a member variable.
        // $conn is set in the constructor.
        protected $conn;

        // Create connection in the constructor
        public function __construct()
        {
            try {
                // Create connection with the command oci_connect(String(username), String(password), String(connection_string))
                // The @ sign avoids the output of warnings
                // It could be helpful to use the function without the @ symbol during developing process
                $this->conn = @oci_connect(
                    DatabaseHelper::username,
                    DatabaseHelper::password,
                    DatabaseHelper::con_string
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

        // This function creates and executes a SQL select statement and returns an array as the result
        // 2-dimensional array: the result array contains nested arrays (each contains the data of a single row)
        public function selectFromPersonWhere()
        {
            // Define the sql statement string
            // Notice that the parameters $person_id, $surname, $name in the 'WHERE' clause
            $sql = "SELECT * FROM student"; //<---------------------------------Tabelle student anlegen!

            // oci_parse(...) prepares the Oracle statement for execution
            // notice the reference to the class variable $this->conn (set in the constructor)
            $statement = @oci_parse($this->conn, $sql);

            // Executes the statement
            @oci_execute($statement);

            // Fetches multiple rows from a query into a two-dimensional array
            // Parameters of oci_fetch_all:
            //   $statement: must be executed before
            //   $res: will hold the result after the execution of oci_fetch_all
            //   $skip: it's null because we don't need to skip rows
            //   $maxrows: it's null because we want to fetch all rows
            //   $flag: defines how the result is structured: 'by rows' or 'by columns'
            //      OCI_FETCHSTATEMENT_BY_ROW (The outer array will contain one sub-array per query row)
            //      OCI_FETCHSTATEMENT_BY_COLUMN (The outer array will contain one sub-array per query column. This is the default.)
            @oci_fetch_all($statement, $res, 0, 0, OCI_FETCHSTATEMENT_BY_ROW);

            //clean up;
            @oci_free_statement($statement);

            return $res;
        }


    }