<?php
class Statistics
{
    public static function productCount(): int
    {
        $result = Database::conn()->query('SELECT COUNT(*) as c FROM products')->fetch();
        return (int)($result['c'] ?? 0);
    }

    public static function userCount(): int
    {
        $result = Database::conn()->query('SELECT COUNT(*) as c FROM users')->fetch();
        return (int)($result['c'] ?? 0);
    }

    public static function paidOrderCount(): int
    {
        $result = Database::conn()->query("SELECT COUNT(*) as c FROM orders WHERE status='paid'")->fetch();
        return (int)($result['c'] ?? 0);
    }
}
