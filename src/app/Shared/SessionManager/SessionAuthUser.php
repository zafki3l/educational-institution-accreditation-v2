<?php

namespace App\Shared\SessionManager;

final class SessionAuthUser
{
    public function __construct(
        public readonly string $user_id,
        public readonly string $identifier,
        public readonly int $role_id
    ) {}
}