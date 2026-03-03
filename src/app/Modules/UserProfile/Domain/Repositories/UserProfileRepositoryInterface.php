<?php

namespace App\Modules\UserProfile\Domain\Repositories;

use App\Modules\UserProfile\Domain\Entities\UserProfile;

interface UserProfileRepositoryInterface
{
    public function getUserProfile(string $id): UserProfile;
    public function update(UserProfile $userProfile): UserProfile;
}