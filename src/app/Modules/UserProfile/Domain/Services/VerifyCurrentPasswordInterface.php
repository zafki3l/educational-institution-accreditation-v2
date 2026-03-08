<?php

namespace App\Modules\UserProfile\Domain\Services;

interface VerifyCurrentPasswordInterface
{
    public function verify(string $password, string $actor_id): void;
}