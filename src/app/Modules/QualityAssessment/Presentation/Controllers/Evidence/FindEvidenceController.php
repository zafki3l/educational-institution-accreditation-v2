<?php

namespace App\Modules\QualityAssessment\Presentation\Controllers\Evidence;

use App\Modules\QualityAssessment\Infrastructure\Models\Evidence;
use App\Modules\QualityAssessment\Infrastructure\Readers\EvidenceReader;
use App\Modules\QualityAssessment\Presentation\Controllers\QualityAssessmentController;
use App\Modules\QualityAssessment\Presentation\Requests\Evidence\SearchEvidenceRequest;
use App\Shared\Application\Contracts\StandardReader\StandardReaderInterface;
use App\Shared\Response\ViewResponse;

final class FindEvidenceController extends QualityAssessmentController
{
    public function __construct(
        private EvidenceReader $evidenceReader,
        private StandardReaderInterface $standardReader
    ) {}

    public function find()
    {
        $standards = $this->standardReader->withCriteria();

        return new ViewResponse(
            self::MODULE_NAME,
            'evidence/find',
            'main.layouts',
            [
                'title' => 'Tìm kiếm minh chứng | ' . SYSTEM_NAME,
                'standards' => $standards
            ]
        );
    }

    public function results(SearchEvidenceRequest $request)
    {
        $standards = $this->standardReader->withCriteria();
        $results = $this->evidenceReader->getSearchResult($request);

        return new ViewResponse(
            self::MODULE_NAME,
            'evidence/search_results',
            'main.layouts',
            [
                'title' => 'Kết quả tìm kiếm | ' . SYSTEM_NAME,
                'evidences' => $results->items,
                'pagination' => $results,
                'standards' => $standards
            ]
        );
    }

    public function viewResults(string $id): ViewResponse
    {
        $standards = $this->standardReader->withCriteria();
        $evidence = Evidence::findOrFail($id);

        return new ViewResponse(
            self::MODULE_NAME,
            'evidence/view_results',
            'main.layouts',
            [
                'title' => "Minh chứng {$id} | " . SYSTEM_NAME,
                'evidence' => $evidence,
                'standards' => $standards
            ]
        );
    }
}