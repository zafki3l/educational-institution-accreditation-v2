<?php

use App\Modules\QualityAssessment\Presentation\Controllers\MilestoneEvidence\CreateMilestoneEvidenceController;
use App\Modules\QualityAssessment\Presentation\Controllers\MilestoneEvidence\DeleteMilestoneEvidenceController;
use App\Modules\QualityAssessment\Presentation\Controllers\MilestoneEvidence\IndexMilestoneEvidenceController;

$route->get('/api/evidences/{id}/criterias', [IndexMilestoneEvidenceController::class, 'index']);
$route->post('/api/evidences/{id}/criterias', [CreateMilestoneEvidenceController::class, 'store']);
$route->delete('/api/evidences/criterias', [DeleteMilestoneEvidenceController::class, 'destroy']);