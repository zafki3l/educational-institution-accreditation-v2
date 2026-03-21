<?php

namespace App\Modules\UserManagement\Application\Responses;

class UserByIdResponse
{
    public function __construct(
        public readonly string $id,
        public readonly string $first_name,
        public readonly string $last_name,
        public readonly string $email,
        public readonly string $role_id,
        public readonly ?string $department_id
    ) {}
}