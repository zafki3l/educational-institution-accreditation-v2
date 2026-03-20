<?php

namespace App\Modules\Authentication\Domain\Events;

final class UserLoggedIn
{
    public function __construct(
        public readonly string $identifier,
        public readonly string $authenticable_user_id
    ) {}
}
