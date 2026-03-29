<?php

namespace App\Modules\DepartmentManagement\Infrastructure\Repositories;

use App\Modules\DepartmentManagement\Domain\Entities\Department as EntitiesDepartment;
use App\Modules\DepartmentManagement\Domain\Repositories\DepartmentRepositoryInterface;
use App\Modules\DepartmentManagement\Infrastructure\Mappers\DepartmentMapper;
use App\Modules\DepartmentManagement\Infrastructure\Models\Department as ModelsDepartment;

class DepartmentRepository implements DepartmentRepositoryInterface
{
    public function create(EntitiesDepartment $entitiesDepartment): void
    {
        ModelsDepartment::create([
            'id' => $entitiesDepartment->getId(),
            'name' => $entitiesDepartment->getName()
        ]);
    }

    public function findOrFail(string $id): ?EntitiesDepartment
    {
        $modelsDepartment = ModelsDepartment::findOrFail($id);

        if (!$modelsDepartment) {
            return null;
        }

        return DepartmentMapper::toDomain($modelsDepartment);
    }

    public function update(EntitiesDepartment $entitiesDepartment): void
    {
        ModelsDepartment::where('id', $entitiesDepartment->getId())
            ->update([
                'name' => $entitiesDepartment->getName()
            ]);
    }

    public function delete(EntitiesDepartment $entitiesDepartment): void
    {
        ModelsDepartment::where('id', $entitiesDepartment->getId())->delete();
    }
}