<?php

class PasswordHandler
{
    private const USERNAME = "a11848674";
    private const PASSWORD = "lZkg9doeYAVKeAQWQtHO";
    private const CONNECTION = "jdbc:oracle:thin:@oracle-lab.cs.univie.ac.at:1521:lab";

    public function getUsername() : string {
        return self::USERNAME;
    }

    public function getPassword() : string {
        return self::PASSWORD;
    }

    public function getConnection() : string {
        return self::CONNECTION;
    }
}