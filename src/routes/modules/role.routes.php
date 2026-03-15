<?php

use App\Modules\Authorization\Presentation\Controllers\Role\CreateRoleController;
use App\Modules\Authorization\Presentation\Controllers\Role\DeleteRoleController;
use App\Modules\Authorization\Presentation\Controllers\Role\IndexRoleController;
use App\Modules\Authorization\Presentation\Controllers\Role\UpdateRoleController;
use App\Shared\Middlewares\EnsureAdmin;
use App\Shared\Middlewares\EnsureAuth;

$route->middleware([EnsureAuth::class, EnsureAdmin::class])
    ->get('/roles', [IndexRoleController::class, 'index']);

$route->middleware([EnsureAuth::class, EnsureAdmin::class])
    ->post('/roles', [CreateRoleController::class, 'store']);

$route->middleware([EnsureAuth::class, EnsureAdmin::class])
    ->put('/roles/update', [UpdateRoleController::class, 'update']);
    
$route->middleware([EnsureAuth::class, EnsureAdmin::class])
    ->delete('/roles/{id}', [DeleteRoleController::class, 'destroy']);