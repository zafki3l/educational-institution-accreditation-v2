<?php

namespace App\Modules\QualityAssessment\Domain\Repositories;

use App\Modules\QualityAssessment\Domain\Entities\Standard as EntitiesStandard;

interface StandardRepositoryInterface
{
    public function create(EntitiesStandard $entitiesStandard): void;

    public function findOrFail(string $id): ?EntitiesStandard;

    public function delete(EntitiesStandard $entitiesStandard): void;

    public function update(EntitiesStandard $entitiesStandard): void;
}