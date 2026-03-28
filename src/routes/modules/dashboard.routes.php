<?php

use App\Modules\Dashboard\Presentation\Controllers\AdminDashboardController;
use App\Modules\Dashboard\Presentation\Controllers\StaffDashboardController;
use App\Shared\Web\Middlewares\EnsureAdmin;
use App\Shared\Web\Middlewares\EnsureAuth;
use App\Shared\Web\Middlewares\EnsureStaff;

$route->middleware([EnsureAuth::class, EnsureAdmin::class])
    ->get('/admin/dashboard', [AdminDashboardController::class, 'dashboard']);
    
$route->middleware([EnsureAuth::class, EnsureStaff::class])
    ->get('/staff/dashboard', [StaffDashboardController::class, 'dashboard']);
