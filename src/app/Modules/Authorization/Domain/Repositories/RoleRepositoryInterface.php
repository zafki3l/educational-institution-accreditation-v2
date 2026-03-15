<?php

namespace App\Modules\Authorization\Domain\Repositories;

use App\Modules\Authorization\Domain\Entities\Role as EntitiesRole;

interface RoleRepositoryInterface
{
    public function findOrFail(int $id): EntitiesRole;

    public function create(EntitiesRole $role): void;

    public function update(EntitiesRole $role): void;

    public function delete(EntitiesRole $role): void;
}