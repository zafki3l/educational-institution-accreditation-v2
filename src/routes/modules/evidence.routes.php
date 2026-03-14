<?php

use App\Modules\QualityAssessment\Presentation\Controllers\Evidence\CreateEvidenceController;
use App\Modules\QualityAssessment\Presentation\Controllers\Evidence\DeleteEvidenceController;
use App\Modules\QualityAssessment\Presentation\Controllers\Evidence\EvidenceMilestoneController;
use App\Modules\QualityAssessment\Presentation\Controllers\Evidence\FindEvidenceController;
use App\Modules\QualityAssessment\Presentation\Controllers\Evidence\IndexEvidenceController;
use App\Modules\QualityAssessment\Presentation\Controllers\Evidence\ShowEvidenceController;
use App\Modules\QualityAssessment\Presentation\Controllers\Evidence\UpdateEvidenceController;
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
    ->get('/api/evidences/{id}/milestones', [EvidenceMilestoneController::class, 'getMilestones']);

$route->middleware([EnsureAuth::class, EnsureStaff::class])
    ->post('/api/evidences/{id}/milestones', [EvidenceMilestoneController::class, 'addMilestone']);

$route->middleware([EnsureAuth::class, EnsureStaff::class])
    ->delete('/api/evidences/{id}/milestones/{mapping_id}', [EvidenceMilestoneController::class, 'removeMilestone']);

$route->middleware([EnsureAuth::class, EnsureStaff::class])
    ->get('/evidences/{id}/edit', [UpdateEvidenceController::class, 'edit']);

$route->middleware([EnsureAuth::class, EnsureStaff::class])
    ->put('/evidences/update', [UpdateEvidenceController::class, 'update']);

$route->middleware([EnsureAuth::class, EnsureStaff::class])
    ->delete('/evidences/{id}', [DeleteEvidenceController::class, 'destroy']);

$route->middleware([EnsureAuth::class])
    ->get('/evidences/{id}/show', [ShowEvidenceController::class, 'show']);

$route->middleware([EnsureAuth::class])
    ->get('/evidences/find', [FindEvidenceController::class, 'find']);

$route->middleware([EnsureAuth::class])
    ->get('/evidences/results', [FindEvidenceController::class, 'results']);

$route->middleware([EnsureAuth::class])
    ->get('/evidences/results/{id}/view', [FindEvidenceController::class, 'viewResults']);