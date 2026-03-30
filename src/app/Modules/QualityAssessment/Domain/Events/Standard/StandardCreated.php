<?php

namespace App\Modules\QualityAssessment\Domain\Events\Standard;

final class StandardCreated
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $department_id,
        public readonly string $actor_id
    ) {}
}