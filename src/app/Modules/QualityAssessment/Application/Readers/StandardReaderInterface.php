<?php

namespace App\Modules\QualityAssessment\Application\Readers;

use Illuminate\Database\Eloquent\Collection;

interface StandardReaderInterface
{
    public function all(): Collection;

    public function withCriteria(): Collection;

    public function withCriteriaByDepartment(string $department_id): Collection;

    public function count(): int;
}