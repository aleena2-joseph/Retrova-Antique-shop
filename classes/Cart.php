<?php
class Cart
{
    public static function dbCartMap(int $userId): array
    {
        $st = Database::conn()->prepare('SELECT product_id, quantity FROM user_carts WHERE user_id = ?');
        $st->execute([$userId]);
        $map = [];
        foreach ($st->fetchAll() as $row) {
            $map[(int)$row['product_id']] = (int)$row['quantity'];
        }
        return $map;
    }

    public static function syncFromDatabase(): void
    {
        if (!User::isLoggedIn()) return;
        $_SESSION['cart'] = self::dbCartMap(User::id());
    }

    public static function mergeSessionToDatabase(): void
    {
        if (!User::isLoggedIn()) return;
        if (empty($_SESSION['cart'])) return;
        $ins = Database::conn()->prepare('INSERT INTO user_carts (user_id, product_id, quantity) VALUES (?,?,?) ON DUPLICATE KEY UPDATE quantity = quantity + VALUES(quantity)');
        foreach ($_SESSION['cart'] as $pid => $qty) {
            $ins->execute([User::id(), (int)$pid, (int)$qty]);
        }
    }

    public static function clear(): void
    {
        $_SESSION['cart'] = [];
        if (User::isLoggedIn()) {
            $st = Database::conn()->prepare('DELETE FROM user_carts WHERE user_id = ?');
            $st->execute([User::id()]);
        }
    }

    public static function add(int $productId, int $qty = 1): void
    {
        if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
        if (!isset($_SESSION['cart'][$productId])) $_SESSION['cart'][$productId] = 0;
        $_SESSION['cart'][$productId] += max(1, $qty);
        if (User::isLoggedIn()) {
            $st = Database::conn()->prepare('INSERT INTO user_carts (user_id, product_id, quantity) VALUES (?,?,?) ON DUPLICATE KEY UPDATE quantity = quantity + VALUES(quantity)');
            $st->execute([User::id(), $productId, max(1, $qty)]);
        }
    }

    public static function remove(int $productId): void
    {
        if (isset($_SESSION['cart'][$productId])) {
            unset($_SESSION['cart'][$productId]);
        }
        if (User::isLoggedIn()) {
            $st = Database::conn()->prepare('DELETE FROM user_carts WHERE user_id = ? AND product_id = ?');
            $st->execute([User::id(), $productId]);
        }
    }

    public static function update(array $items): void
    {
        $_SESSION['cart'] = [];
        foreach ($items as $pid => $qty) {
            $pid = (int)$pid; $qty = (int)$qty;
            if ($qty > 0) $_SESSION['cart'][$pid] = $qty;
        }
        if (User::isLoggedIn()) {
            $uid = User::id();
            $del = Database::conn()->prepare('DELETE FROM user_carts WHERE user_id = ?');
            $del->execute([$uid]);
            if (!empty($_SESSION['cart'])) {
                $ins = Database::conn()->prepare('INSERT INTO user_carts (user_id, product_id, quantity) VALUES (?,?,?)');
                foreach ($_SESSION['cart'] as $pid => $qty) {
                    $ins->execute([$uid, (int)$pid, (int)$qty]);
                }
            }
        }
    }

    public static function items(): array
    {
        if (User::isLoggedIn()) {
            self::syncFromDatabase();
        }
        $items = [];
        if (!empty($_SESSION['cart'])) {
            $ids = array_map('intval', array_keys($_SESSION['cart']));
            if ($ids) {
                $in = implode(',', array_fill(0, count($ids), '?'));
                $st = Database::conn()->prepare("SELECT * FROM products WHERE id IN ($in)");
                $st->execute($ids);
                $map = [];
                foreach ($st->fetchAll() as $p) { $map[$p['id']] = $p; }
                foreach ($_SESSION['cart'] as $pid => $qty) {
                    if (isset($map[$pid])) {
                        $p = $map[$pid];
                        $p['qty'] = (int)$qty;
                        $p['total'] = $p['qty'] * $p['price'];
                        $items[] = $p;
                    }
                }
            }
        }
        return $items;
    }

    public static function total(): float
    {
        $sum = 0.0;
        foreach (self::items() as $it) { $sum += (float)$it['total']; }
        return $sum;
    }
}
