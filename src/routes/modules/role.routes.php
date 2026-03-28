<?php

use App\Modules\Authorization\Presentation\Controllers\CreateRoleController;
use App\Modules\Authorization\Presentation\Controllers\DeleteRoleController;
use App\Modules\Authorization\Presentation\Controllers\IndexRoleController;
use App\Modules\Authorization\Presentation\Controllers\UpdateRoleController;
use App\Shared\Web\Middlewares\EnsureAdmin;
use App\Shared\Web\Middlewares\EnsureAuth;

$route->middleware([EnsureAuth::class, EnsureAdmin::class])
    ->get('/roles', [IndexRoleController::class, 'index']);

$route->middleware([EnsureAuth::class, EnsureAdmin::class])
    ->post('/roles', [CreateRoleController::class, 'store']);

$route->middleware([EnsureAuth::class, EnsureAdmin::class])
    ->put('/roles/update', [UpdateRoleController::class, 'update']);
    
$route->middleware([EnsureAuth::class, EnsureAdmin::class])
    ->delete('/roles/{id}', [DeleteRoleController::class, 'destroy']);