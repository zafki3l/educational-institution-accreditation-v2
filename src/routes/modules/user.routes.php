<?php

use App\Modules\UserManagement\Presentation\Controllers\CreateUserController;
use App\Modules\UserManagement\Presentation\Controllers\DeleteUserController;
use App\Modules\UserManagement\Presentation\Controllers\IndexUserController;
use App\Modules\UserManagement\Presentation\Controllers\UpdateUserController;
use App\Shared\Web\Middlewares\EnsureAdmin;
use App\Shared\Web\Middlewares\EnsureAuth;

$route->middleware([EnsureAuth::class, EnsureAdmin::class])
    ->get('/users', [IndexUserController::class, 'index']);

$route->middleware([EnsureAuth::class, EnsureAdmin::class])
    ->post('/users', [CreateUserController::class, 'store']);

$route->middleware([EnsureAuth::class, EnsureAdmin::class])
    ->get('/users/{id}/edit', [UpdateUserController::class, 'edit']);

$route->middleware([EnsureAuth::class, EnsureAdmin::class])
    ->put('/users/update', [UpdateUserController::class, 'update']);
    
$route->middleware([EnsureAuth::class, EnsureAdmin::class])
    ->delete('/users/{id}', [DeleteUserController::class, 'destroy']);