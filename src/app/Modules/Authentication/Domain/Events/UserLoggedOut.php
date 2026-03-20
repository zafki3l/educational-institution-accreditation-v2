<?php

namespace App\Modules\Authentication\Domain\Events;

final class UserLoggedOut
{
    public function __construct(public readonly string $authenticable_user_id) {}
}
