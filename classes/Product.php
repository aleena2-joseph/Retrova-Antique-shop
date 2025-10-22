<?php
class Product
{
    public static function find(int $id): ?array
    {
        $st = Database::conn()->prepare('SELECT * FROM products WHERE id = ?');
        $st->execute([$id]);
        $row = $st->fetch();
        return $row ?: null;
    }

    public static function search(string $q = '', ?int $categoryId = null): array
    {
        $sql = 'SELECT p.*, c.name AS category_name FROM products p LEFT JOIN categories c ON c.id = p.category_id WHERE 1';
        $params = [];
        if ($q !== '') { $sql .= ' AND (p.title LIKE ? OR p.description LIKE ?)'; $params[] = "%$q%"; $params[] = "%$q%"; }
        if ($categoryId) { $sql .= ' AND p.category_id = ?'; $params[] = $categoryId; }
        $sql .= ' ORDER BY p.created_at DESC';
        $st = Database::conn()->prepare($sql);
        $st->execute($params);
        return $st->fetchAll();
    }

    public static function getAllWithCategory(): array
    {
        $st = Database::conn()->query('SELECT p.*, c.name AS category_name FROM products p LEFT JOIN categories c ON c.id = p.category_id ORDER BY p.created_at DESC');
        return $st->fetchAll();
    }

    public static function create(string $title, string $description, float $price, int $stock, ?string $image, ?int $categoryId): int
    {
        $st = Database::conn()->prepare('INSERT INTO products (title, description, price, stock, image, category_id) VALUES (?, ?, ?, ?, ?, ?)');
        $st->execute([$title, $description, $price, $stock, $image, $categoryId]);
        return (int)Database::conn()->lastInsertId();
    }

    public static function update(int $id, string $title, string $description, float $price, int $stock, ?string $image, ?int $categoryId): bool
    {
        $st = Database::conn()->prepare('UPDATE products SET title=?, description=?, price=?, stock=?, image=?, category_id=? WHERE id=?');
        return $st->execute([$title, $description, $price, $stock, $image, $categoryId, $id]);
    }

    public static function delete(int $id): bool
    {
        $st = Database::conn()->prepare('DELETE FROM products WHERE id = ?');
        return $st->execute([$id]);
    }

    public static function decreaseStock(int $productId, int $quantity): bool
    {
        $st = Database::conn()->prepare('UPDATE products SET stock = GREATEST(0, stock - ?) WHERE id = ?');
        return $st->execute([$quantity, $productId]);
    }
}
