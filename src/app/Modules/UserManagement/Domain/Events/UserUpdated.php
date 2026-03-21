<?php

namespace App\Modules\UserManagement\Domain\Events;

final class UserUpdated
{
    public function __construct(
        public readonly string $user_id,
        public readonly array $changes,
        public readonly string $actor_id
    ) {}
}