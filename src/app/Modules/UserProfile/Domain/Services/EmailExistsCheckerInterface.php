<?php

namespace App\Modules\UserProfile\Domain\Services;

interface EmailExistsCheckerInterface
{
    public function isExists(string $email): bool;
}