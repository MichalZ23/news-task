<?php

declare(strict_types=1);

namespace App\Security;

final readonly class PasswordHasher
{
    public static function hash(string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }
}
