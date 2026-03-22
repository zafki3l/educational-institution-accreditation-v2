<?php

namespace App\Modules\Dashboard\Application\Responses;

final class UserManagementStatsResponse
{
    public function __construct(
        public readonly int $total_users,
        public readonly int $total_staffs,
        public readonly int $total_departments,
        public readonly int $total_roles
    ) {}
}