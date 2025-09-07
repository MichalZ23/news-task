<?php

declare(strict_types=1);

namespace App\Model;

abstract readonly class AbstractModel
{
    abstract public static function createFromArray(array $data): self;
}
