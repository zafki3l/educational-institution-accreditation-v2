<?php

namespace App\Modules\QualityAssessment\Domain\Events\Standard;

final class StandardUpdated
{
    public function __construct(
        public readonly string $id,
        public readonly array $changes,
        public readonly string $actor_id
    ) {}
}