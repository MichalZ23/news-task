<?php

declare(strict_types=1);

namespace App\Router;

use App\Controller\AuthController;
use App\Controller\NewsController;
use App\Model\News\News;

final readonly class AppPostRouter
{
    public function __construct(
        private AuthController $authController,
        private NewsController $newsController,
    ) {
    }

    public function handlePost(string $action, array $post): array
    {
        return match ($action) {
            'login' => $this->authController->login($post),
            'logout' => $this->authController->logout(),
            'create_news' => $this->newsController->create(new News(null, $post['title'], $post['description'])),
            'update_news' => $this->newsController->update(new News(
                (int) $post['id'],
                $post['title'],
                $post['description'],
            )),
            'delete_news' => $this->newsController->delete((int)$post['id']),
            default => ['ok' => false, 'error' => 'Unknown action'],
        };
    }
}
