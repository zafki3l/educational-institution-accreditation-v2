<?php

namespace App\Modules\UserManagement\Presentation\ViewModel;

final class EditUserViewModel
{
    public function __construct(
        public readonly string $id,
        public readonly string $first_name,
        public readonly string $last_name,
        public readonly string $email,
        public readonly string $role_id,
        public readonly ?string $department_id
    ) {}

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email ?? '',
            'role_id' => $this->role_id,
            'department_id' => $this->department_id ?? ''
        ];
    }
}