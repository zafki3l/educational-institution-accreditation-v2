<?php

use App\Shared\Security\Csrf\CsrfTokenGenerator;
use App\Shared\Security\Session\SessionGenerator;
use Dotenv\Dotenv;
use Illuminate\Pagination\Paginator;

require dirname(__DIR__, 2) . '/vendor/autoload.php';

Paginator::currentPageResolver(function () {
    return $_GET['page'] ?? 1;
});

Paginator::currentPathResolver(function () {
    return strtok($_SERVER['REQUEST_URI'], '?');
});

SessionGenerator::generate();
CsrfTokenGenerator::generate();

$dotenv = Dotenv::createImmutable(dirname(__DIR__, 2));
$dotenv->load();
foreach ($_ENV as $key => $value) {
    $_SERVER[$key] = $value;
}

require_once 'database.php';
require_once 'container/container.php';