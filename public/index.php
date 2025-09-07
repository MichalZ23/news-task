<?php
declare(strict_types=1);

use App\Controller\AppPostRouteController;
use App\Controller\AuthController;
use App\Controller\NewsController;
use App\Model\News\NewsRepository;
use App\Notification\FlashMessageManager;
use App\Security\Auth;

require __DIR__ . '/../src/bootstrap.php';

$flashMessageManager = new FlashMessageManager();
$flash = $flashMessageManager->pullMessage();

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$auth = new Auth($pdo);
$newsController = new NewsController(
    new NewsRepository($pdo),
    $twig,
);

$appRouteController = new AppPostRouteController(
    new AuthController(
        $auth,
        $twig,
    ),
    $newsController,
    $flashMessageManager,
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
    : $twig->render('Partials/login.twig');

echo $twig->render('layout.twig', ['partial' => $partial]);
