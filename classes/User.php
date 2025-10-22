<?php
class User
{
    public int $id;
    public string $name;
    public string $email;
    public string $password_hash;
    public string $role = 'user';

    public static function fromRow(array $row): self
    {
        $u = new self();
        $u->id = (int)$row['id'];
        $u->name = $row['name'];
        $u->email = $row['email'];
        $u->password_hash = $row['password_hash'];
        $u->role = $row['role'];
        return $u;
    }

    public static function findByEmailOrName(string $emailOrName): ?self
    {
        $st = Database::conn()->prepare('SELECT * FROM users WHERE email = ? OR name = ? LIMIT 1');
        $st->execute([$emailOrName, $emailOrName]);
        $row = $st->fetch();
        return $row ? self::fromRow($row) : null;
    }

    public static function findByEmail(string $email): ?self
    {
        $st = Database::conn()->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
        $st->execute([$email]);
        $row = $st->fetch();
        return $row ? self::fromRow($row) : null;
    }

    public static function register(string $name, string $email, string $password): bool
    {
        $st = Database::conn()->prepare('SELECT id FROM users WHERE email = ? LIMIT 1');
        $st->execute([$email]);
        if ($st->fetch()) return false;
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $ins = Database::conn()->prepare("INSERT INTO users (name,email,password_hash,role) VALUES (?,?,?, 'user')");
        return $ins->execute([$name, $email, $hash]);
    }

    public static function login(string $emailOrName, string $password): bool
    {
        $u = self::findByEmailOrName($emailOrName);
        if (!$u) return false;
        if (!password_verify($password, $u->password_hash)) return false;
        $_SESSION['user'] = [
            'id' => $u->id,
            'name' => $u->name,
            'email' => $u->email,
            'role' => $u->role,
        ];
        return true;
    }

    public static function current(): ?array
    {
        return $_SESSION['user'] ?? null;
    }

    public static function id(): ?int
    {
        return $_SESSION['user']['id'] ?? null;
    }

    public static function isLoggedIn(): bool
    {
        return isset($_SESSION['user']);
    }

    public static function isAdmin(): bool
    {
        return isset($_SESSION['user']) && ($_SESSION['user']['role'] ?? '') === 'admin';
    }
}
