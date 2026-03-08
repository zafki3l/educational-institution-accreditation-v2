<?php

namespace App\Modules\UserProfile\Infrastructure\Services;

use App\Modules\UserManagement\Domain\ValueObjects\Password;
use App\Modules\UserManagement\Infrastructure\Models\User;
use App\Modules\UserProfile\Domain\Exceptions\PasswordIncorrectException;
use App\Modules\UserProfile\Domain\Services\VerifyCurrentPasswordInterface;

final class VerifyCurrentPassword implements VerifyCurrentPasswordInterface
{
    public function verify(string $password, string $actor_id): void
    {
        $user = User::findOrFail($actor_id);
        $current_password = Password::fromHash($user->password);

        if (!$current_password->verify($password)) {
            throw new PasswordIncorrectException();
        }
    }
}