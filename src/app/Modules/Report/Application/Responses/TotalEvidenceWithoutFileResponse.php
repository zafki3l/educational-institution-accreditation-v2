<?php

namespace App\Modules\Report\Application\Responses;

final class TotalEvidenceWithoutFileResponse
{
    public function __construct(
        public readonly array $evidences,
        public readonly int $count
    ) {}
}