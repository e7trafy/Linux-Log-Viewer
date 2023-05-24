<?php

namespace App;

class Auth
{
    public static function isAuthenticated(): bool
    {
        return isset($_SESSION['loggedin']) && $_SESSION['loggedin'];
    }

    public static function login(string $username, string $password): bool
    {
        if ($username === 'admin' && $password === 'admin') {
            $_SESSION['loggedin'] = true;
            return true;
        }

        return false;
    }

    public static function logout(): void
    {
        unset($_SESSION['loggedin']);
    }
}