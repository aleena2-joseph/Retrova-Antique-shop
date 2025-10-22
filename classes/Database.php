<?php
class Database
{
    private static ?PDO $pdo = null;

    public static function init(string $host, string $dbName, string $user, string $pass): void
    {
        if (self::$pdo) return;
        $pdo = new PDO('mysql:host=' . $host . ';charset=utf8mb4', $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
        $pdo->exec("CREATE DATABASE IF NOT EXISTS `" . $dbName . "` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        $pdo->exec("USE `" . $dbName . "`");

        // Schema bootstrap (mirrors prior config.php logic)
        $pdo->exec("CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(191) NOT NULL UNIQUE,
            password_hash VARCHAR(255) NOT NULL,
            role ENUM('admin','user') NOT NULL DEFAULT 'user',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB");

        $pdo->exec("CREATE TABLE IF NOT EXISTS categories (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            slug VARCHAR(150) NOT NULL UNIQUE
        ) ENGINE=InnoDB");

        $pdo->exec("CREATE TABLE IF NOT EXISTS products (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(200) NOT NULL,
            description TEXT NOT NULL,
            price DECIMAL(10,2) NOT NULL,
            stock INT NOT NULL DEFAULT 0,
            image VARCHAR(255) DEFAULT NULL,
            category_id INT DEFAULT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
        ) ENGINE=InnoDB");

        $pdo->exec("CREATE TABLE IF NOT EXISTS orders (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            razorpay_order_id VARCHAR(191) NOT NULL,
            razorpay_payment_id VARCHAR(191) DEFAULT NULL,
            razorpay_signature VARCHAR(255) DEFAULT NULL,
            amount INT NOT NULL,
            status ENUM('created','paid','failed') NOT NULL DEFAULT 'created',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id)
        ) ENGINE=InnoDB");

        $pdo->exec("CREATE TABLE IF NOT EXISTS order_items (
            id INT AUTO_INCREMENT PRIMARY KEY,
            order_id INT NOT NULL,
            product_id INT NOT NULL,
            quantity INT NOT NULL,
            price DECIMAL(10,2) NOT NULL,
            FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
            FOREIGN KEY (product_id) REFERENCES products(id)
        ) ENGINE=InnoDB");

        $pdo->exec("CREATE TABLE IF NOT EXISTS user_carts (
            user_id INT NOT NULL,
            product_id INT NOT NULL,
            quantity INT NOT NULL DEFAULT 1,
            PRIMARY KEY (user_id, product_id),
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
            FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
        ) ENGINE=InnoDB");

        // Seed admin
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ? OR name = ? LIMIT 1");
        $stmt->execute(['admin@retrova.local', 'admin']);
        if (!$stmt->fetch()) {
            $passwordHash = password_hash('admin123', PASSWORD_BCRYPT);
            $ins = $pdo->prepare("INSERT INTO users (name,email,password_hash,role) VALUES (?,?,?, 'admin')");
            $ins->execute(['admin', 'admin@retrova.local', $passwordHash]);
        }

        self::$pdo = $pdo;
    }

    public static function conn(): PDO
    {
        if (!self::$pdo) {
            throw new RuntimeException('Database::init() must be called before using the connection.');
        }
        return self::$pdo;
    }
}
