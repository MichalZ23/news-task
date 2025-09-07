<?php

declare(strict_types=1);

namespace App\Model\User;

use App\Model\AbstractModel;

final readonly class User extends AbstractModel
{
    public function __construct(
        private int $id,
        private string $login,
        private string $password,
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public static function createFromArray(array $data): AbstractModel
    {
        return new self(
            (int) $data['id'],
            (string) $data['login'],
            (string) $data['password'],
        );
    }
}
