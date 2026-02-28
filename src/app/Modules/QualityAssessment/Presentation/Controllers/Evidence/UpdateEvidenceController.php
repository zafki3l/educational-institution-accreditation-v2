<?php

namespace App\Modules\QualityAssessment\Presentation\Controllers\Evidence;

use App\Modules\QualityAssessment\Domain\Services\EvidenceFileUploaderInterface;
use App\Modules\QualityAssessment\Infrastructure\Models\Evidence;
use App\Modules\QualityAssessment\Presentation\Controllers\QualityAssessmentController;
use App\Modules\QualityAssessment\Presentation\Requests\Evidence\UpdateEvidenceRequest;
use App\Shared\Response\ViewResponse;

final class UpdateEvidenceController extends QualityAssessmentController
{
    public function __construct(private EvidenceFileUploaderInterface $evidenceFileUploader) {}

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
        $evidence = Evidence::with(['milestone.criteria.standard'])->findOrFail($request->getId());

        $data = [
            'name' => $request->getName(),
            'document_number' => $request->getDocumentNumber(),
            'issued_date' => $request->getIssuedDate(),
            'issuing_authority' => $request->getIssuingAuthority()
        ];

        if ($request->getFile()['error'] === UPLOAD_ERR_OK) {
            $data['file_url'] = $this->evidenceFileUploader->upload($request->getFile(), $request->getId());
        }

        $evidence->update($data);

        $evidence->refresh();

        $this->redirect("/criterias/{$evidence->milestone->criteria->id}/evidences");
    }
}