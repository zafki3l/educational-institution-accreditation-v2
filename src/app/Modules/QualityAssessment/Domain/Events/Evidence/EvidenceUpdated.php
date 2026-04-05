<?php

namespace App\Modules\QualityAssessment\Domain\Events\Evidence;

final class EvidenceUpdated
{
    public function __construct(
        public readonly string $id,
        public readonly array $changes,
        public readonly string $actor_id
    ) {}
}