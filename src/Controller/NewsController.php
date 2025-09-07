<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\News\NewsRepository;
use Twig\Environment;

final readonly class NewsController
{
    public function __construct(
        private NewsRepository $newsRepository,
        private Environment $twig,
    ) {
    }

    public function getDashboard(?string $flash = null): string
    {
        $news = $this->newsRepository->findAll();

        return $this->twig->render('Partials/dashboard.twig', ['news' => $news, 'flash' => $flash]);
    }

    public function delete(int $id): void
    {
        $this->newsRepository->delete($id);
    }

    public function create(array $params): void
    {
        $this->newsRepository->create($params);
    }

    public function update(array $params): void
    {
        $this->newsRepository->update($params);
    }
}
