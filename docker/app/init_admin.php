<?php

declare(strict_types=1);

require __DIR__ . '/../../vendor/autoload.php';

use App\Infrastructure\Factory\PdoFactory;
use App\Security\PasswordHasher;

try {
    $pdo = PdoFactory::create();

    $query = $pdo->prepare('SELECT COUNT(*) FROM users WHERE login = ?');
    $query->execute(['admin']);
    $adminExists = $query->fetchColumn();

    if (!$adminExists) {
        $hash = PasswordHasher::hash('test');
        $query = $pdo->prepare('INSERT INTO users (login, password) VALUES (?, ?)');
        $query->execute(['admin', $hash]);

        echo "Admin created\n";
    }

} catch (PDOException $e) {
    echo "{$e->getMessage()}\n";
    exit(1);
}
