<?php

namespace App\Modules\UserManagement\Domain\Entities;

use App\Modules\UserManagement\Domain\Exception\RoleMissingException;
use App\Modules\UserManagement\Domain\Exception\UserNameEmptyException;
use App\Modules\UserManagement\Domain\ValueObjects\Email;
use App\Modules\UserManagement\Domain\ValueObjects\Password;
use App\Modules\UserManagement\Domain\ValueObjects\UserId;

class User
{
    private array $changes = [];

    private function __construct(
        private UserId $id,
        private string $first_name,
        private string $last_name,
        private Email $email,
        private Password $password,
        private int $role_id,
        private ?string $department_id
    ) {}

    public static function create(
        UserId $id,
        string $first_name,
        string $last_name,
        Email $email,
        Password $password,
        int $role_id,
        ?string $department_id
    ): self {
        self::isUserNameEmpty($first_name, $last_name);
        self::isRoleIdEmpty($role_id);

        return new self($id, $first_name, $last_name, $email, $password, $role_id, $department_id);
    }

    public function update(
        string $new_first_name,
        string $new_last_name,
        Email $new_email,
        int $new_role_id,
        ?string $new_department_id,
    ) {
        self::isUserNameEmpty($new_first_name, $new_last_name);
        self::isRoleIdEmpty($new_role_id);

        if ($this->first_name !== $new_first_name) {
            $this->changes['first_name'] = [
                'old' => $this->first_name,
                'new' => $new_first_name
            ];

            $this->changeFirstName($new_first_name);
        }

        if ($this->last_name !== $new_last_name) {
            $this->changes['last_name'] = [
                'old' => $this->last_name,
                'new' => $new_last_name
            ];

            $this->changeLastName($new_last_name);
        }

        if (!$this->email->equals($new_email)) {
            $this->changes['email'] = [
                'old' => $this->email->value(),
                'new' => $new_email->value()
            ];

            $this->changeEmail($new_email);
        }

        if ($this->role_id !== $new_role_id) {
            $this->changes['role_id'] = [
                'old' => $this->role_id,
                'new' => $new_role_id
            ];

            $this->changeRoleId($new_role_id);
        }

        if ($this->department_id !== $new_department_id) {
            $this->changes['department_id'] = [
                'old' => $this->department_id,
                'new' => $new_department_id
            ];

            $this->changeDepartmentId($new_department_id);
        }
    }

    public function getUserId(): UserId
    {
        return $this->id;
    }

    public function getFirstName(): string
    {
        return $this->first_name;
    }

    public function getLastName(): string
    {
        return $this->last_name;
    }

    public function getFullName(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getPassword(): Password
    {
        return $this->password;
    }

    public function getRoleId(): int
    {
        return $this->role_id;
    }

    public function getDepartmentId(): ?string
    {
        return $this->department_id;
    }

    public function getChanges(): array
    {
        return $this->changes;
    }

    public function changeFirstName(string $first_name): void
    {
        $this->first_name = $first_name;
    }

    public function changeLastName(string $last_name): void
    {
        $this->last_name = $last_name;
    }

    public function changeEmail(Email $email): void
    {
        $this->email = $email;
    }

    public function changePassword(Password $password): void
    {
        $this->password = $password;
    }

    public function changeRoleId(int $role_id): void
    {
        $this->role_id = $role_id;
    }

    public function changeDepartmentId(?string $department_id): void
    {
        $this->department_id = $department_id;
    }

    private static function isUserNameEmpty(string $first_name, string $last_name): void
    {
        if (empty($first_name) || empty($last_name)) {
            throw new UserNameEmptyException();
        }
    }

    private static function isRoleIdEmpty(int $role_id): void
    {
        if (empty($role_id)) {
            throw new RoleMissingException();
        }
    }
}
