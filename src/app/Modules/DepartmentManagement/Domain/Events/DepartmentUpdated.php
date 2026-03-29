<?php

namespace App\Modules\DepartmentManagement\Domain\Events;

final class DepartmentUpdated
{
    public function __construct(
        public readonly string $id,
        public readonly array $changes,
        public readonly string $actor_id
    ) {}
}