<?php

use App\Modules\StaffManagement\Presentation\Controllers\CreateStaffController;
use App\Modules\StaffManagement\Presentation\Controllers\DeleteStaffController;
use App\Modules\StaffManagement\Presentation\Controllers\IndexStaffController;
use App\Modules\StaffManagement\Presentation\Controllers\UpdateStaffController;
use App\Shared\Web\Middlewares\EnsureAdmin;
use App\Shared\Web\Middlewares\EnsureAuth;

$route->middleware([EnsureAuth::class, EnsureAdmin::class])
    ->get('/staffs', [IndexStaffController::class, 'index']);

$route->middleware([EnsureAuth::class, EnsureAdmin::class])
    ->get('/staffs/create', [CreateStaffController::class, 'create']);

$route->middleware([EnsureAuth::class, EnsureAdmin::class])
    ->post('/staffs', [CreateStaffController::class, 'store']);

$route->middleware([EnsureAuth::class, EnsureAdmin::class])
    ->get('/staffs/{id}/edit', [UpdateStaffController::class, 'edit']);

$route->middleware([EnsureAuth::class, EnsureAdmin::class])
    ->put('/staffs/update', [UpdateStaffController::class, 'update']);
    
$route->middleware([EnsureAuth::class, EnsureAdmin::class])
    ->delete('/staffs/{id}', [DeleteStaffController::class, 'destroy']);