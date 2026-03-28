<?php

use App\Modules\QualityAssessment\Presentation\Controllers\Criteria\CreateCriteriaController;
use App\Modules\QualityAssessment\Presentation\Controllers\Criteria\DeleteCriteriaController;
use App\Modules\QualityAssessment\Presentation\Controllers\Criteria\IndexCriteriaController;
use App\Modules\QualityAssessment\Presentation\Controllers\Criteria\UpdateCriteriaController;
use App\Shared\Web\Middlewares\EnsureAdmin;
use App\Shared\Web\Middlewares\EnsureAuth;
use App\Shared\Web\Middlewares\EnsureStaff;

$route->middleware([EnsureAuth::class, EnsureStaff::class])
    ->get('/criterias', [IndexCriteriaController::class, 'index']);

$route->middleware([EnsureAuth::class, EnsureAdmin::class])
    ->post('/criterias', [CreateCriteriaController::class, 'store']);

$route->middleware([EnsureAuth::class, EnsureAdmin::class])
    ->get('/criterias/{id}/edit', [UpdateCriteriaController::class, 'edit']);

$route->middleware([EnsureAuth::class, EnsureAdmin::class])
    ->put('/criterias/update', [UpdateCriteriaController::class, 'update']);

$route->middleware([EnsureAuth::class, EnsureAdmin::class])
    ->delete('/criterias/{id}', [DeleteCriteriaController::class, 'destroy']);