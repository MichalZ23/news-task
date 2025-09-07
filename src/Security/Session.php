<?php

declare(strict_types=1);

namespace App\Security;

use App\Model\User\User;

final readonly class Session
{
    public static function start(string $name): void
    {
        session_name($name);
        session_start();
    }

    public static function updateAfterLogin(User $user): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_regenerate_id(true);
        }

        $_SESSION['user_id'] = $user->getId();
        $_SESSION['login'] = $user->getLogin();
    }

    public static function destroy(): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_regenerate_id(true);
        }

        session_destroy();
    }
}
