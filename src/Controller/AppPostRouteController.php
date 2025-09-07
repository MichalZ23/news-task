<?php

declare(strict_types=1);

namespace App\Controller;

use App\Notification\FlashMessageManager;

final readonly class AppPostRouteController
{
    public function __construct(
        private AuthController $authController,
        private NewsController $newsController,
        private FlashMessageManager $flashMessageManager,
    ) {
    }

    public function handlePost(string $action, array $post): array
    {
        switch ($action) {
            case 'login':
                $loginResponse = $this->authController->login($post);
                if (!$loginResponse['ok']) {
                    return $loginResponse;
                }

                return ['ok' => true, 'html' => $this->newsController->getDashboard()];
            case 'logout':
                return $this->authController->logout();
            case 'create_news':
                $this->newsController->create([
                    'title' => $post['title'],
                    'description' => $post['description'],
                ]);
                $this->flashMessageManager->setMessage('News was successfully created!');

                return ['ok' => true, 'redirect' => '/'];
            case 'update_news':
                $this->newsController->update([
                    'id' => $post['id'],
                    'title' => $post['title'],
                    'description' => $post['description'],
                ]);

                $this->flashMessageManager->setMessage('News was successfully changed!');

                return ['ok' => true, 'redirect' => '/'];
            case 'delete_news':
                $this->newsController->delete((int) $post['id']);
                $this->flashMessageManager->setMessage('News was deleted!');

                return ['ok' => true, 'redirect' => '/'];
            default:
                return ['ok' => false, 'error' => 'Unknown action'];
        }
    }
}
