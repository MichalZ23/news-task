<?php

declare(strict_types=1);

namespace App\Model\User;

use App\Model\AbstractModel;

final readonly class User extends AbstractModel
{
    public function __construct(
        ?int $id,
        private string $login,
        private string $password,
    ) {
        parent::__construct($id);
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public static function createFromDbArray(array $data): AbstractModel
    {
        if ($data['id'] === null) {
            throw new \LogicException('User ID is null');
        }

        return new self(
            (int) $data['id'],
            (string) $data['login'],
            (string) $data['password'],
        );
    }
}
