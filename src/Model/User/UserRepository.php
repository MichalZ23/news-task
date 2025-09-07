<?php

declare(strict_types=1);

namespace App\Model\User;

use App\Model\AbstractRepository;
use PDO;

/** @template-extends AbstractRepository<User> */
final readonly class UserRepository extends AbstractRepository
{
    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo, 'users', User::class);
    }
}
