<?php

namespace App\Modules\UserProfile\Infrastructure\Services;

use App\Modules\UserManagement\Infrastructure\Models\User;
use App\Modules\UserProfile\Domain\Services\EmailExistsCheckerInterface;

final class EmailExistsChecker implements EmailExistsCheckerInterface
{
    public function isExists(string $email): bool
    {
        return User::query()
                ->where('email', $email)
                ->exists();
    }
}