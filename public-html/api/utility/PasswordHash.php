<?php

namespace public\api\utility;

class PasswordHash
{
    public static function hash(string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public static function verify(
        string $password,
        string $hashedPassword
    ): bool {
        return password_verify($password, $hashedPassword);
    }
}

