<?php

declare(strict_types=1);

namespace App\Model\News;

use App\Model\AbstractModel;

final readonly class News extends AbstractModel
{
    private const int MAX_TITLE_LENGTH = 20;
    private const int MAX_DESCRIPTION_LENGTH = 200;

    private string $title;
    private string $description;

    public function __construct(
        ?int $id,
        string $title,
        string $description,
    ) {
        parent::__construct($id);
        $this->title = substr($title, 0, self::MAX_TITLE_LENGTH);
        $this->description = substr($description, 0, self::MAX_DESCRIPTION_LENGTH);
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public static function createFromDbArray(array $data): AbstractModel
    {
        if ($data['id'] === null) {
            throw new \LogicException('News ID is null');
        }

        return new self(
            (int) $data['id'],
            (string) $data['title'],
            (string) $data['description'],
        );
    }
}
