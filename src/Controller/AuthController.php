<?php

declare(strict_types=1);

namespace App\Controller;

use App\Notification\FlashMessage;
use App\Notification\FlashMessageManager;
use App\Notification\FlashMessageTypeEnum;
use App\Security\Auth;

final readonly class AuthController extends BaseController
{
    public function __construct(
        private Auth $auth,
        private FlashMessageManager $flashMessageManager,
    ) {
    }

    public function login(array $post): array
    {
        $login = (string) ($post['login'] ?? '');
        $password = (string) ($post['password'] ?? '');
        if ($this->auth->login($login, $password)) {
            return $this->getSuccessResponse();
        }

        $this->flashMessageManager->setFlashMessage(
            new FlashMessage('Wrong Login Data!', FlashMessageTypeEnum::ERROR),
        );

        return $this->getErrorResponse();
    }

    public function logout(): array
    {
        $this->auth->logout();

        return $this->getSuccessResponse();
    }
}
