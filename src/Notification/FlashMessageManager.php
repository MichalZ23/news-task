<?php

declare(strict_types=1);

namespace App\Notification;

final readonly class FlashMessageManager
{
    public function setFlashMessage(
        FlashMessage $flashMessage,
    ): void {
        $_SESSION["flash"] = [
            'message' => $flashMessage->getMessage(),
            'type' => $flashMessage->getType()->value,
        ];
    }

    public function pullMessage(): ?FlashMessage
    {
        $message = $this->getMessage();
        $this->clear();

        return $message;
    }

    private function getMessage(): ?FlashMessage
    {
        if (!isset($_SESSION["flash"]['message']) && !isset($_SESSION["flash"]['type'])) {
            return null;
        }

        return new FlashMessage(
            $_SESSION["flash"]['message'],
            FlashMessageTypeEnum::from($_SESSION["flash"]['type'])
        );
    }

    private function clear(): void
    {
        unset($_SESSION["flash"]);
    }
}
