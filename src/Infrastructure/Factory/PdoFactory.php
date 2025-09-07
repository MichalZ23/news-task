<?php

declare(strict_types=1);

namespace App\Infrastructure\Factory;

use PDO;

final readonly class PdoFactory
{
    public static function create(): PDO
    {
        $user = getenv('MYSQL_USER') ?: 'user';
        $password = getenv('MYSQL_PASSWORD') ?: 'password';
        $dsn = getenv('MYSQL_DSN') ?: 'dsn';

        return new PDO($dsn, $user, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
    }
}
