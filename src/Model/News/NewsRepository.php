<?php

declare(strict_types=1);

namespace App\Model\News;

use App\Model\AbstractRepository;
use PDO;

/** @template-extends AbstractRepository<News> */
final readonly class NewsRepository extends AbstractRepository
{
    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo, 'news', News::class);
    }
}
