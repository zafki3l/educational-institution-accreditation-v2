<?php

namespace App\Modules\UserProfile\Presentation\Controllers;

use App\Modules\UserManagement\Infrastructure\Models\User;
use App\Shared\Response\ViewResponse;
use App\Shared\SessionManager\AuthSession;

final class IndexUserProfileController extends UserProfileController
{
    public function index()
    {
        $user = User::select('first_name', 'last_name', 'email')
                    ->findOrFail(AuthSession::getUserId());
                    
        return new ViewResponse(
            self::MODULE_NAME,
            'index',
            'main.layouts',
            [
                'title' => 'Hồ sơ cá nhân',
                'user' => $user
            ]
        );
    }
}