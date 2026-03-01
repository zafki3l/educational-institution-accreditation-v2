<?php

namespace App\Modules\QualityAssessment\Presentation\Controllers\Evidence;

use App\Modules\QualityAssessment\Infrastructure\Models\Evidence;
use App\Modules\QualityAssessment\Presentation\Controllers\QualityAssessmentController;
use App\Shared\Application\Contracts\StandardReader\StandardReaderInterface;
use App\Shared\Response\ViewResponse;

final class ShowEvidenceController extends QualityAssessmentController
{
    public function __construct(private StandardReaderInterface $standardReader) {}

    public function show(string $id): ViewResponse
    {
        $standards = $this->standardReader->withCriteria();
        $evidence = Evidence::findOrFail($id);

        return new ViewResponse(
            self::MODULE_NAME,
            'evidence/show',
            'main.layouts',
            [
                'title' => "Minh chứng {$id} | " . SYSTEM_NAME,
                'evidence' => $evidence,
                'standards' => $standards
            ]
        );
    }
}