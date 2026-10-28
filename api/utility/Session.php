<?php

namespace public\api\utility;

class Session
{
    /* espesific variavel */
    public static function set(
        string $key,
        mixed $value
    ): void {
        $_SESSION[$key] = $value;
    }

    // Errors (array)
    public static function setError(
        string $type,
        string $message
    ): void {
        $_SESSION['error'][$type] = $message;
    }

    // Old form data (array)
    public static function setOldData(
        array $data
    ): void {
        $_SESSION['oldData'] = $data;
    }

    public static function isProfessional(): void
    {
        $User = $_SESSION['user'];

        if (!isset($User) || $User['role'] !== 'professional') {
            header('Location: /reservaja/login');
            exit();
        }
    }
}
