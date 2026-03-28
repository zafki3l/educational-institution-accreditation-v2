<?php

namespace App\Shared\Web\Middlewares;

use App\Modules\Authentication\Domain\Exception\PermissionDeniedException;

final class EnsureAdmin
{
    private const ROLE_ADMIN = 3;

    public function handle(): void
    {
        $role_id = $_SESSION['auth_user']['role_id'] ?? null;
        
        if ($role_id !== self::ROLE_ADMIN) {
            throw new PermissionDeniedException();
        }
    }
}