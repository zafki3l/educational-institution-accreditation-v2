<?php

namespace App\Modules\QualityAssessment\Infrastructure\Readers;

use App\Modules\QualityAssessment\Infrastructure\Models\Standard;
use App\Shared\Application\Contracts\StandardReader\StandardReaderInterface;
use Illuminate\Database\Eloquent\Collection;

class StandardReader implements StandardReaderInterface
{
    public function all(): Collection
    {
        $standards = Standard::with('department')
                        ->orderByRaw('CAST(id AS UNSIGNED) ASC')
                        ->get();

        return $standards;
    }

    public function withCriteria(): Collection
    {
        $standards = Standard::with('criteria')
                        ->orderByRaw('CAST(id AS UNSIGNED) ASC')
                        ->get();

        return $standards;
    }

    public function withCriteriaByDepartment(string $department_id): Collection
    {
        $standards = Standard::with('criteria')
                        ->where('department_id', $department_id)
                        ->orderByRaw('CAST(id AS UNSIGNED) ASC')
                        ->get();

        return $standards;
    }

    public function count(): int
    {
        return Standard::count();
    }
}