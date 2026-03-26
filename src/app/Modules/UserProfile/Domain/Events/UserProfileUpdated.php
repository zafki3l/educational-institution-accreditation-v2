<?php

namespace App\Modules\UserProfile\Domain\Events;

final class UserProfileUpdated
{
    public function __construct(
        public readonly string $actor_id,
        public readonly string $old_first_name,
        public readonly string $new_first_name,
        public readonly string $old_last_name,
        public readonly string $new_last_name,
        public readonly ?string $old_email,
        public readonly ?string $new_email,
    ) {}
}