<?php

namespace App\Modules\UserProfile\Presentation\Controllers;

use App\Shared\Http\Traits\HttpResponse;

abstract class UserProfileController
{
    use HttpResponse;

    public const MODULE_NAME = 'UserProfile';
}