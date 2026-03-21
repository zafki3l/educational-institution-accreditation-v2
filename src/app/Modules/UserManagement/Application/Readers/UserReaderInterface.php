<?php

namespace App\Modules\UserManagement\Application\Readers;

use App\Modules\UserManagement\Application\Responses\UserByIdResponse;
use App\Shared\Domain\UserRole;
use App\Shared\Paginator\PaginatedResult;

interface UserReaderInterface
{
    public function all(?string $keyword, ?int $role_id): PaginatedResult;

    public function allStaffs(?string $keyword, int $role_id = UserRole::ROLE_STAFF);

    public function findById(string $id): UserByIdResponse;

    public function count(): int;

    public function countByRoleId(int $role_id): int;
}