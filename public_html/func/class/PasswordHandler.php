<?php

class PasswordHandler
{
    private const USERNAME = "a11848674";
    private const PASSWORD = 'dwH$KI6<hBS)#"oy3*bg';
    private const CONNECTION = "//oracle-lab.cs.univie.ac.at:1521/lab";

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