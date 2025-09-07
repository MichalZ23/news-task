<?php

declare(strict_types=1);

namespace App\Notification;

final readonly class FlashMessageManager
{
    public function setMessage(string $message): void
    {
        $_SESSION["flash"] = $message;
    }

    public function pullMessage(): ?string
    {
        $message = $this->getMessage();
        $this->clear();

        return $message;
    }

    private function getMessage(): ?string
    {
        return $_SESSION["flash"] ?? null;
    }

    private function clear(): void
    {
        unset($_SESSION["flash"]);
    }
}
