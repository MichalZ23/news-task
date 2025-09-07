<?php

declare(strict_types=1);

namespace App\Controller;

use App\Security\Auth;
use Twig\Environment;

final readonly class AuthController
{
    public function __construct(
        private Auth $auth,
        private Environment $twig,
    ) {
    }

    public function login(array $post): array
    {
        $login = (string) ($post['login'] ?? '');
        $password = (string) ($post['password'] ?? '');
        if ($this->auth->login($login, $password)) {
            return ['ok' => true];
        }

        return ['ok' => false, 'error' => 'Wrong Login Data!'];
    }

    public function logout(): array
    {
        $this->auth->logout();
        $html = $this->twig->render('Partials/login.twig');

        return ['ok' => true, 'html' => $html];
    }
}
