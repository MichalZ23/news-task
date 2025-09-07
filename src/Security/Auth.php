<?php

namespace App\Security;

use App\Model\User\UserRepository;
use PDO;

final readonly class Auth
{
    private UserRepository $userRepository;

    public function __construct(PDO $pdo)
    {
        $this->userRepository = new UserRepository($pdo);
    }

    public function login(string $login, string $password): bool
    {
        $user = $this->userRepository->findBy('login', $login);

        $fakePassword = PasswordHasher::hash('not_the_password');
        $hash = $user?->getPassword() ?? $fakePassword;

        if (password_verify($password, $hash) && $user) {
            Session::updateAfterLogin($user);

            return true;
        }

        return false;
    }

    public function checkUserIsLoggedIn(): bool
    {
        return isset($_SESSION['user_id']);
    }

    public function logout(): void
    {
        Session::destroy();
    }
}
