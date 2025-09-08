<?php

declare(strict_types=1);

namespace App\Notification;

enum FlashMessageTypeEnum: string
{
    case ERROR = 'error';
    case INFO = 'info';
}
