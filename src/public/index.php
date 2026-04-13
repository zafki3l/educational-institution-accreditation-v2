<?php

use App\Shared\Web\Responses\JsonResponse;
use App\Shared\Web\Responses\ViewResponse;
use Core\Router;
use Core\ViewRender;

error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__DIR__) . '/logs/error.log');

require_once '../configs/path.php';
require_once '../configs/name.php';
require_once '../helpers/authHelper.php';

require dirname(__DIR__, 2) . '/vendor/autoload.php';

require_once '../bootstrap/app.php';

$route = new Router();

$rootPath = '/' . basename(dirname(__DIR__));
$path = str_replace($rootPath, '', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

foreach (glob(dirname(__DIR__) . '/routes/*.php') as $filename) {
    require_once $filename;
}

$response = $route->dispatch($path, $_SERVER['REQUEST_METHOD']);

if ($response instanceof ViewResponse) {
    $viewRender = new ViewRender();
    $viewRender->view($response);
    
    if (function_exists('fastcgi_finish_request')) {
        fastcgi_finish_request();
    }
} else if ($response instanceof JsonResponse) {
    $response->send();
    
    if (function_exists('fastcgi_finish_request')) {
        fastcgi_finish_request();
    }
} 

