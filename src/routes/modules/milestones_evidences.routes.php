<?php

use App\Modules\QualityAssessment\Presentation\Controllers\MilestoneEvidence\CreateMilestoneEvidenceController;
use App\Modules\QualityAssessment\Presentation\Controllers\MilestoneEvidence\DeleteMilestoneEvidenceController;
use App\Modules\QualityAssessment\Presentation\Controllers\MilestoneEvidence\IndexMilestoneEvidenceController;
use App\Shared\Web\Middlewares\EnsureAuth;
use App\Shared\Web\Middlewares\EnsureStaff;

$route->middleware([EnsureAuth::class, EnsureStaff::class])
    ->get('/api/evidences/{id}/criterias', [IndexMilestoneEvidenceController::class, 'index']);

$route->middleware([EnsureAuth::class, EnsureStaff::class])
    ->post('/api/evidences/{id}/criterias', [CreateMilestoneEvidenceController::class, 'store']);

$route->middleware([EnsureAuth::class, EnsureStaff::class])
    ->delete('/api/evidences/criterias', [DeleteMilestoneEvidenceController::class, 'destroy']);