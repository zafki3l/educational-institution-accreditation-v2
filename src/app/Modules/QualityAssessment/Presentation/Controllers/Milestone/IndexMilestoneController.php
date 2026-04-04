<?php

namespace App\Modules\QualityAssessment\Presentation\Controllers\Milestone;

use App\Modules\QualityAssessment\Application\Readers\MilestoneReaderInterface;
use App\Modules\QualityAssessment\Presentation\Controllers\QualityAssessmentController;
use App\Shared\Web\Responses\JsonResponse;

final class IndexMilestoneController extends QualityAssessmentController
{
    public function __construct(private MilestoneReaderInterface $milestoneReader) {}

    public function index(string $criteria_id): JsonResponse
    {
        $criteria = $this->milestoneReader->getByCriteriaId($criteria_id);

        return new JsonResponse(['criteria' => $criteria]);
    }
}