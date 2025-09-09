<?php

declare(strict_types=1);

namespace App\Model;

use ReflectionObject;

abstract readonly class AbstractModel
{
    protected ?int $id;

    public function __construct(?int $id)
    {
        $this->id = $id;
    }

    abstract public static function createFromDbArray(array $data): self;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function toParams(): array
    {
        $reflectionObject = new ReflectionObject($this);
        $params = [];

        foreach ($reflectionObject->getProperties() as $property) {
            $property->setAccessible(true);
            $value = $property->getValue($this);
            if ($value !== null || $property->getName() !== 'id') {
                $params[$property->getName()] = $value;
            }
            $property->setAccessible(false);
        }

        return $params;
    }
}
