<?php

declare(strict_types=1);

namespace App\Notification;

final readonly class FlashMessage
{
    public function __construct(
        private string $message,
        private FlashMessageTypeEnum $type = FlashMessageTypeEnum::INFO,
    ) {
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getType(): FlashMessageTypeEnum
    {
        return $this->type;
    }
}
