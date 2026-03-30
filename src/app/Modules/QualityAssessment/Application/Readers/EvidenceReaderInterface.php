<?php

namespace App\Modules\QualityAssessment\Application\Readers;

use App\Modules\QualityAssessment\Application\Requests\Evidence\SearchEvidenceRequestInterface;
use App\Shared\Domain\Paginator\PaginatedResult;

interface EvidenceReaderInterface
{
    public function getSearchResult(SearchEvidenceRequestInterface $request): PaginatedResult;

    public function count(): int;

    public function countByDepartment(string $department_id): int;
}