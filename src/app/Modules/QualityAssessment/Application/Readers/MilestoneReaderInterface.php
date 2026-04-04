<?php

namespace App\Modules\QualityAssessment\Application\Readers;

interface MilestoneReaderInterface
{
    public function getByCriteriaId(string $criteria_id): array;

    public function count(): int;

    public function getCodeById(int $id): string;
}