<?php

declare(strict_types=1);

namespace App\Model\News;

use App\Model\AbstractModel;

final readonly class News extends AbstractModel
{
    public function __construct(
        private int $id,
        private string $title,
        private string $description,
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public static function createFromArray(array $data): AbstractModel
    {
        return new self(
            (int) $data['id'],
            (string) $data['title'],
            (string) $data['description'],
        );
    }
}
