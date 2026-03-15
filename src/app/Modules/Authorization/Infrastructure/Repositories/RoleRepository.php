<?php

namespace App\Modules\Authorization\Infrastructure\Repositories;

use App\Modules\Authorization\Domain\Entities\Role as EntitiesRole;
use App\Modules\Authorization\Domain\Repositories\RoleRepositoryInterface;
use App\Modules\Authorization\Infrastructure\Mappers\RoleMapper;
use App\Modules\Authorization\Infrastructure\Models\Role as ModelsRole;

final class RoleRepository implements RoleRepositoryInterface
{
    public function findOrFail(int $id): EntitiesRole
    {
        $modelsRole = ModelsRole::findOrFail($id);

        return RoleMapper::toDomain($modelsRole);
    }

    public function create(EntitiesRole $entitiesRole): void
    {
        ModelsRole::create([
            'name' => $entitiesRole->getName()
        ]);   
    }

    public function update(EntitiesRole $entitiesRole): void
    {
        ModelsRole::where('id', $entitiesRole->getId())->update([
            'name' => $entitiesRole->getName()
        ]);
    }

    public function delete(EntitiesRole $role): void
    {
        ModelsRole::where('id', $role->getId())->delete();
    }
}