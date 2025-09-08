<?php
declare(strict_types=1);

use App\Controller\AuthController;
use App\Controller\NewsController;
use App\Model\News\NewsRepository;
use App\Notification\FlashMessageManager;
use App\Router\AppPostRouter;
use App\Security\Auth;
// TODO add README
require __DIR__ . '/../src/bootstrap.php';

$flashMessageManager = new FlashMessageManager();
$flash = $flashMessageManager->pullMessage();

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$auth = new Auth($pdo);
$newsController = new NewsController(
    new NewsRepository($pdo),
    $twig,
    $flashMessageManager,
);

$appRouteController = new AppPostRouter(
    new AuthController(
        $auth,
        $flashMessageManager,
    ),
    $newsController,
);

if ($method === 'POST') {
    //todo add csrf
    $action = $_POST["action"] ?? '';
    $response = $appRouteController->handlePost($action, $_POST);

    echo json_encode($response);
    exit;
}

$partial = $auth->checkUserIsLoggedIn()
    ? $newsController->getDashboard($flash)
    : $twig->render('Partials/login.twig', ['flash' => $flash]);

echo $twig->render('layout.twig', ['partial' => $partial]);
