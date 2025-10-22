<?php
class AuthService
{
    public static function requireLogin(): void
    {
        if (!User::isLoggedIn()) {
            header('Location: ' . BASE_URL . '/login.php');
            exit;
        }
    }

    public static function requireAdmin(): void
    {
        if (!User::isAdmin()) {
            header('Location: ' . BASE_URL . '/login.php');
            exit;
        }
    }

    public static function logout(): void
    {
        session_destroy();
        header('Location: ' . BASE_URL . '/login.php');
        exit;
    }
}
