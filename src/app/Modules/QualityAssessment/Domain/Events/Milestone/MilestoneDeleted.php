<?php

namespace App\Modules\QualityAssessment\Domain\Events\Milestone;

final class MilestoneDeleted
{
    public function __construct(
        public readonly int $id,
        public readonly string $criteria_id,
        public readonly string $code,
        public readonly int $order,
        public readonly string $name,
        public readonly string $actor_id
    ) {}
}