<?php

namespace App\Modules\UserProfile\Domain\Events;

final class PasswordChanged
{
    public function __construct(
        public readonly string $actor_id
    ) {}
}