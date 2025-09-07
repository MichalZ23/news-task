<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\Infrastructure\Factory\PdoFactory;
use App\Security\Session;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

$APP_ENV = getenv('APP_ENV') ?: 'dev';
$SESSION_NAME = getenv('SESSION_NAME') ?: 'APPSESSID';

Session::start($SESSION_NAME);

try {
    $pdo = PdoFactory::create();
} catch (Throwable $e) {
    http_response_code(500);
    echo 'DB connection failed';
    error_log($e->getMessage());
    exit;
}

$loader = new FilesystemLoader(__DIR__ . '/Views');
$twig = new Environment($loader, [
    'cache' => false,
    'autoescape' => 'html',
    'strict_variables' => true,
    'debug'=> $APP_ENV === 'dev',
    ],
);

$twig->addExtension(new DebugExtension());
$twig->addGlobal('session', $_SESSION);
$twig->addGlobal('app_env', $APP_ENV);
