<?php

namespace App\Modules\QualityAssessment\Application\Readers;

use App\Modules\QualityAssessment\Presentation\Requests\Evidence\SearchEvidenceRequest;
use App\Shared\Paginator\PaginatedResult;

interface EvidenceReaderInterface
{
    public function getSearchResult(SearchEvidenceRequest $request): PaginatedResult;

    public function count(): int;

    public function countByDepartment(string $department_id): int;
}