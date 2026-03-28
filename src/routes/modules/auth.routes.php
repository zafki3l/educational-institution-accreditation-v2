<?php

use App\Modules\Authentication\Presentation\Controllers\LoginController;
use App\Modules\Authentication\Presentation\Controllers\LogoutController;
use App\Shared\Web\Middlewares\EnsureAuth;

$route->get('/login', [LoginController::class, 'showLogin']);

$route->post('/login', [LoginController::class, 'login']);

$route->middleware([EnsureAuth::class])
    ->post('/logout', [LogoutController::class, 'logout']);