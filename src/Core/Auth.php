<?php

namespace App\Core;

class Auth
{
    public static function user()
    {
        return $_SESSION['user'] ?? null;
    }

    public static function check()
    {
        return isset($_SESSION['user']);
    }

    public static function isAdmin()
    {
        return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';
    }

    public static function requireLogin()
    {
        if (!self::check()) {
            header('Location: /login');
            exit;
        }
    }

    public static function requireAdmin()
    {
        if (!self::isAdmin()) {
            http_response_code(403);
            echo "Accès interdit";
            exit;
        }
    }
}
