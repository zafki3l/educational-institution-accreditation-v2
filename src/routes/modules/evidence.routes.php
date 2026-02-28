<?php

use App\Modules\QualityAssessment\Presentation\Controllers\Evidence\CreateEvidenceController;
use App\Modules\QualityAssessment\Presentation\Controllers\Evidence\DeleteEvidenceController;
use App\Modules\QualityAssessment\Presentation\Controllers\Evidence\IndexEvidenceController;
use App\Shared\Middlewares\EnsureAuth;
use App\Shared\Middlewares\EnsureStaff;

$route->middleware([EnsureAuth::class, EnsureStaff::class])
    ->get('/criterias/{criteria_id}/evidences', [IndexEvidenceController::class, 'index']);

$route->middleware([EnsureAuth::class, EnsureStaff::class])
    ->get('/evidences/create', [CreateEvidenceController::class, 'create']);

$route->middleware([EnsureAuth::class, EnsureStaff::class])
    ->post('/evidences', [CreateEvidenceController::class, 'store']);

$route->middleware([EnsureAuth::class, EnsureStaff::class])
    ->get('/api/standards', [CreateEvidenceController::class, 'getAllStandard']);

$route->middleware([EnsureAuth::class, EnsureStaff::class])
    ->get('/api/standards/{standard_id}/criterias', [CreateEvidenceController::class, 'getAllCriteriasByStandard']);

$route->middleware([EnsureAuth::class, EnsureStaff::class])
    ->get('/api/criterias/{criteria_id}/milestones', [CreateEvidenceController::class, 'getAllMilestonesByCriteria']);

$route->middleware([EnsureAuth::class, EnsureStaff::class])
    ->delete('/evidences/{id}', [DeleteEvidenceController::class, 'destroy']);