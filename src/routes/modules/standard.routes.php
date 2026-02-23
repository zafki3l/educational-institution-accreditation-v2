<?php

use App\Modules\QualityAssessment\Presentation\Controllers\Standard\CreateStandardController;
use App\Modules\QualityAssessment\Presentation\Controllers\Standard\DeleteStandardController;
use App\Modules\QualityAssessment\Presentation\Controllers\Standard\IndexStandardController;
use App\Modules\QualityAssessment\Presentation\Controllers\Standard\UpdateStandardController;
use App\Shared\Middlewares\EnsureAdmin;
use App\Shared\Middlewares\EnsureAuth;
use App\Shared\Middlewares\EnsureStaff;

$route->middleware([EnsureAuth::class, EnsureStaff::class])
    ->get('/standards', [IndexStandardController::class, 'index']);

$route->middleware([EnsureAuth::class, EnsureAdmin::class])
    ->get('/standards/create', [CreateStandardController::class, 'create']);

$route->middleware([EnsureAuth::class, EnsureAdmin::class])
    ->post('/standards', [CreateStandardController::class, 'store']);

$route->middleware([EnsureAuth::class, EnsureAdmin::class])
    ->delete('/standards/{id}', [DeleteStandardController::class, 'destroy']);

$route->middleware([EnsureAuth::class, EnsureAdmin::class])
    ->get('/standards/{id}/edit', [UpdateStandardController::class, 'edit']);

$route->middleware([EnsureAuth::class, EnsureAdmin::class])
    ->put('/standards', [UpdateStandardController::class, 'update']);