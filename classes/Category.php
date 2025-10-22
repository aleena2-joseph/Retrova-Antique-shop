<?php
class Category
{
    public int $id;
    public string $name;
    public string $slug;

    public static function all(): array
    {
        $st = Database::conn()->query('SELECT * FROM categories ORDER BY name');
        return $st->fetchAll();
    }
}
