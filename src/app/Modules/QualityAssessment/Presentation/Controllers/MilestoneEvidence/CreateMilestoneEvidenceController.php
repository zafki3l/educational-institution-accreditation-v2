<?php

namespace App\Modules\QualityAssessment\Presentation\Controllers\MilestoneEvidence;

use App\Modules\QualityAssessment\Application\UseCases\MilestoneEvidence\CreateMilestoneEvidenceUseCase;
use App\Modules\QualityAssessment\Presentation\Controllers\QualityAssessmentController;
use App\Modules\QualityAssessment\Presentation\Requests\MilestoneEvidence\CreateMilestoneEvidenceRequest;
use App\Shared\Exception\DomainException;
use App\Shared\SessionManager\AuthSession;

use App\Shared\Response\JsonResponse;

final class CreateMilestoneEvidenceController extends QualityAssessmentController
{
    public function __construct(private CreateMilestoneEvidenceUseCase $createMilestoneEvidenceUseCase) {}

    public function store(CreateMilestoneEvidenceRequest $request): JsonResponse
    {
        try {
            $this->createMilestoneEvidenceUseCase->execute($request, AuthSession::getUserId());
        
            return new JsonResponse([
                'success' => true,
                'message' => 'Thêm mốc đánh giá thành công'
            ]);
        } catch (DomainException $e) {
            return new JsonResponse([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}