<?php

namespace App\Shared\Web\Middlewares;

use App\Modules\Authentication\Domain\Exception\PermissionDeniedException;

final class EnsureStaff 
{
    private const ROLE_ADMIN = 3;
    private const ROLE_STAFF = 2;
    
    public function handle(): void
    {
        $role_id = $_SESSION['auth_user']['role_id'] ?? null;
        
        if (!in_array($role_id, [self::ROLE_ADMIN, self::ROLE_STAFF])) {
            throw new PermissionDeniedException();
        }
    }
}