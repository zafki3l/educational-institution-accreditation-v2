<?php

use App\Modules\QualityAssessment\Presentation\Controllers\MilestoneEvidence\IndexMilestoneEvidenceController;

$route->get('/api/evidences/{id}/criterias', [IndexMilestoneEvidenceController::class, 'index']);