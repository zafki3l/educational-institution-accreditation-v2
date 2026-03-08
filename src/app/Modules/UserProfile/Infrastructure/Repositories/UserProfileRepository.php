<?php

namespace App\Modules\UserProfile\Infrastructure\Repositories;

use App\Modules\UserManagement\Infrastructure\Models\User;
use App\Modules\UserProfile\Domain\Entities\UserProfile;
use App\Modules\UserProfile\Domain\Repositories\UserProfileRepositoryInterface;

class UserProfileRepository implements UserProfileRepositoryInterface
{
    public function getUserProfile(string $id): UserProfile
    {
        $user = User::findOrFail($id);
        
        $userProfile = UserProfile::fromPersistent(
            $user->id, 
            $user->first_name, 
            $user->last_name, 
            !empty($user->email) ? $user->email : null,
            $user->password
        );

        return $userProfile;
    }

    public function update(UserProfile $userProfile): UserProfile
    {
        $user = User::findOrFail($userProfile->getId());

        $data = [
            'first_name' => $userProfile->getFirstName(),
            'last_name' => $userProfile->getLastName(),
        ];

        if ($userProfile->getEmail() !== null) {
            $data['email'] = $userProfile->getEmail();
        }

        $user->update($data);

        $user->refresh();

        return UserProfile::fromPersistent(
            $user->id,
            $user->first_name,
            $user->last_name,
            !empty($user->email) ? $user->email : null,
            null
        );
    }

    public function changePassword(string $new_password, string $actor_id): UserProfile
    {
        $user = User::findOrFail($actor_id);

        $user->update([
            'password' => $new_password
        ]);

        $user->refresh();

        return UserProfile::fromPersistent(
            $user->id,
            $user->first_name,
            $user->last_name,
            null,
            null
        );
    }
}