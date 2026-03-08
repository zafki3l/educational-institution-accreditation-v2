<?php

use App\Modules\UserProfile\Presentation\Controllers\ChangePasswordController;
use App\Modules\UserProfile\Presentation\Controllers\IndexUserProfileController;
use App\Modules\UserProfile\Presentation\Controllers\UpdateUserProfileController;
use App\Shared\Middlewares\EnsureAuth;

$route->middleware([EnsureAuth::class])
    ->get('/profile', [IndexUserProfileController::class, 'index']);

$route->middleware([EnsureAuth::class])
    ->put('/profile/update', [UpdateUserProfileController::class, 'update']);

$route->middleware([EnsureAuth::class])
    ->patch('/profile/change-password', [ChangePasswordController::class, 'change']);