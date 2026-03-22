<?php

namespace App\Modules\Dashboard\Application\Responses;

final class StandardManagementStatsResponse
{
    public function __construct(
        public readonly int $total_standards,
        public readonly int $total_criterias,
        public readonly int $total_milestones,
        public readonly int $total_evidences
    ) {}
}