<?php

namespace App\Modules\Authentication\Infrastructure\Mappers;

use App\Modules\Authentication\Domain\Entities\AuthenticableUser;
use App\Modules\UserManagement\Domain\ValueObjects\Password;
use App\Modules\UserManagement\Domain\ValueObjects\UserId;
use App\Modules\UserManagement\Infrastructure\Models\User as ModelsUser;

final class AuthenticableUserMapper
{
    public static function toDomain(ModelsUser $user, $identifier): AuthenticableUser
    {
        return AuthenticableUser::create(
            UserId::fromString($user->id),
            $identifier,
            Password::fromHash($user->password),
            $user->role_id
        );
    }
}