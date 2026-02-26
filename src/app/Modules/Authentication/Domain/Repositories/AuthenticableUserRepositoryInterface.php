<?php

namespace App\Modules\Authentication\Domain\Repositories;

use App\Modules\Authentication\Domain\Entities\AuthenticableUser;

interface AuthenticableUserRepositoryInterface
{
    public function findByIdentifier(string $auth_id): ?AuthenticableUser;
}