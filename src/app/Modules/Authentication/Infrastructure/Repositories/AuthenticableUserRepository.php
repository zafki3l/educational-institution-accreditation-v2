<?php

namespace App\Modules\Authentication\Infrastructure\Repositories;

use App\Modules\Authentication\Domain\Entities\AuthenticableUser;
use App\Modules\Authentication\Domain\Repositories\AuthenticableUserRepositoryInterface;
use App\Modules\Authentication\Infrastructure\Mappers\AuthenticableUserMapper;
use App\Modules\UserManagement\Infrastructure\Models\User as ModelsUser;

final class AuthenticableUserRepository implements AuthenticableUserRepositoryInterface
{
    public function findByIdentifier(string $identifier): ?AuthenticableUser
    {
        $modelsUser = ModelsUser::select(['id', 'auth_id', 'password', 'role_id'])
                    ->where(function ($query) use ($identifier) {
                        $query->where('auth_id', $identifier)
                            ->orWhere('email', $identifier);
                    })
                    ->first();
        
        return $modelsUser 
            ? AuthenticableUserMapper::toDomain($modelsUser, $identifier)
            : null;
    }
}