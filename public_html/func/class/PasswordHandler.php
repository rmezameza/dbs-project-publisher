<?php

class PasswordHandler
{
    private const USERNAME = "username";                // In the course I used my student id
    private const PASSWORD = 'password';
    private const CONNECTION = "address_of_database";

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
