<?php

declare(strict_types=1);

namespace App\Controller;

readonly class BaseController
{
    protected function getSuccessResponse(): array
    {
        return ['ok' => true, 'redirect' => '/'];
    }

    protected function getErrorResponse(): array
    {
        return ['ok' => false, 'redirect' => '/'];
    }
}
