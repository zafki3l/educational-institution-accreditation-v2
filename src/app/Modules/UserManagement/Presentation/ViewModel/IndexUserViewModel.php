<?php

namespace App\Modules\UserManagement\Presentation\ViewModel;

class IndexUserViewModel
{
    public function __construct(
        public readonly string $id,
        public readonly string $first_name,
        public readonly string $last_name,
        public readonly string $email,
        public readonly string $role_name,
        public readonly ?string $department_name
    ) {}
}