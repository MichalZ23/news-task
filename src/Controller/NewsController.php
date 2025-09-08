<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\News\NewsRepository;
use App\Notification\FlashMessage;
use App\Notification\FlashMessageManager;
use Twig\Environment;

final readonly class NewsController extends BaseController
{
    public function __construct(
        private NewsRepository $newsRepository,
        private Environment $twig,
        private FlashMessageManager $flashMessageManager,
    ) {
    }

    public function getDashboard(?FlashMessage $flash = null): string
    {
        $news = $this->newsRepository->findAll();

        return $this->twig->render('Partials/dashboard.twig', ['news' => $news, 'flash' => $flash]);
    }

    public function delete(int $id): array
    {
        $this->newsRepository->delete($id);
        $this->flashMessageManager->setFlashMessage(new FlashMessage('News was deleted!'));

        return $this->getSuccessResponse();
    }

    public function create(array $params): array
    {
        $this->newsRepository->create($params);
        $this->flashMessageManager->setFlashMessage(new FlashMessage('News was successfully created!'));

        return $this->getSuccessResponse();
    }

    public function update(array $params): array
    {
        $this->newsRepository->update($params);
        $this->flashMessageManager->setFlashMessage(new FlashMessage('News was successfully changed!'));

        return $this->getSuccessResponse();
    }
}
