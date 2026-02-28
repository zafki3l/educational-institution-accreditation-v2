<?php

namespace App\Modules\QualityAssessment\Presentation\Controllers\Evidence;

use App\Modules\QualityAssessment\Application\UseCases\Evidence\UpdateEvidenceUseCase;
use App\Modules\QualityAssessment\Infrastructure\Models\Evidence;
use App\Modules\QualityAssessment\Presentation\Controllers\QualityAssessmentController;
use App\Modules\QualityAssessment\Presentation\Requests\Evidence\UpdateEvidenceRequest;
use App\Shared\Response\ViewResponse;
use App\Shared\SessionManager\AuthSession;

final class UpdateEvidenceController extends QualityAssessmentController
{
    public function __construct(private UpdateEvidenceUseCase $updateEvidenceUseCase) {}

    public function edit(string $id): ViewResponse
    {
        $evidence = Evidence::with(['milestone.criteria.standard'])->findOrFail($id);

        return new ViewResponse(
            self::MODULE_NAME,
            'evidence/edit',
            'main.layouts',
            [
                'title' => 'Cập nhật minh chứng đánh giá | ' . SYSTEM_NAME,
                'evidence' => $evidence
            ]
        );
    }

    public function update(UpdateEvidenceRequest $request): void
    {
        $criteria_id = $this->updateEvidenceUseCase->execute($request, AuthSession::getUserId());

        $this->redirect("/criterias/{$criteria_id}/evidences");
    }
}