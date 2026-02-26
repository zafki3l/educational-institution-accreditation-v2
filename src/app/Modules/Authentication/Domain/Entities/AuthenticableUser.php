<?php

namespace App\Modules\Authentication\Domain\Entities;

use App\Modules\UserManagement\Domain\ValueObjects\Password;
use App\Modules\UserManagement\Domain\ValueObjects\UserId;

class AuthenticableUser
{
    private function __construct(
        private UserId $user_id,
        private string $identifier,
        private Password $password,
        private int $role_id
    ) {}

    public static function create(
        UserId $user_id,
        string $identifier,
        Password $password,
        int $role_id
    ): self {
        return new self(
            $user_id,
            $identifier,
            $password,
            $role_id
        );
    }

    public function getUserId(): UserId
    {
        return $this->user_id;
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public function getPassword(): Password
    {
        return $this->password;
    }

    public function getRoleId(): int
    {
        return $this->role_id;
    }

    public function verify(string $plain): bool
    {
        return $this->password->verify($plain);
    }
}