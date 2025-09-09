<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\News\News;
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

    public function create(News $news): array
    {
        $this->newsRepository->insert($news->toParams());
        $this->flashMessageManager->setFlashMessage(new FlashMessage('News was successfully created!'));

        return $this->getSuccessResponse();
    }

    public function update(News $news): array
    {
        $this->newsRepository->update($news->toParams());
        $this->flashMessageManager->setFlashMessage(new FlashMessage('News was successfully changed!'));

        return $this->getSuccessResponse();
    }
}
