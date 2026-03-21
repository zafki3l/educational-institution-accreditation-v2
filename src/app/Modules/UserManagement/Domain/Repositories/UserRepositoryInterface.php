<?php

namespace App\Modules\UserManagement\Domain\Repositories;

use App\Modules\UserManagement\Domain\Entities\User as EntitiesUser;

interface UserRepositoryInterface
{
    public function create(EntitiesUser $entitiesUser): EntitiesUser;

    public function findOrFail(string $id): EntitiesUser;

    public function update(EntitiesUser $entitiesUser): void;

    public function delete(string $id): void;
}