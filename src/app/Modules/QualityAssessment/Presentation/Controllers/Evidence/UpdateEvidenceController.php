<?php

namespace App\Modules\QualityAssessment\Presentation\Controllers\Evidence;

use App\Modules\QualityAssessment\Application\Readers\StandardReaderInterface;
use App\Modules\QualityAssessment\Application\UseCases\Evidence\UpdateEvidenceUseCase;
use App\Modules\QualityAssessment\Infrastructure\Models\Evidence;
use App\Modules\QualityAssessment\Presentation\Controllers\QualityAssessmentController;
use App\Modules\QualityAssessment\Presentation\Requests\Evidence\UpdateEvidenceRequest;
use App\Shared\Domain\Exception\DomainException;
use App\Shared\SessionManager\AuthSession;
use App\Shared\Web\Responses\ViewResponse;

final class UpdateEvidenceController extends QualityAssessmentController
{
    public function __construct(
        private UpdateEvidenceUseCase $updateEvidenceUseCase,
        private StandardReaderInterface $standardReader
    ) {}

    public function edit(string $id): ViewResponse
    {
        $sidebarStandards = $this->renderSidebarStandards($this->standardReader);
        $evidence = Evidence::with(['milestone.criteria.standard'])->findOrFail($id);

        return new ViewResponse(
            self::MODULE_NAME,
            'evidence/edit',
            'main.layouts',
            [
                'title' => 'Cập nhật minh chứng đánh giá | ' . SYSTEM_NAME,
                'evidence' => $evidence,
                'sidebarStandards' => $sidebarStandards
            ]
        );
    }

    public function update(UpdateEvidenceRequest $request): void
    {
        try {
            $criteria_id = $this->updateEvidenceUseCase->execute($request, AuthSession::getUserId());

            $this->redirect("/criterias/{$criteria_id}/evidences?success=updated");
        } catch (DomainException $e) {
            $_SESSION['errors'] = [$e->getMessage()];

            $this->redirect("/evidences/{$request->getId()}/edit");
        }
    }
}