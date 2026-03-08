<?php

namespace App\Modules\UserProfile\Application\Requests;

interface ChangePasswordRequestInterface
{
    public function getCurrentPassword(): string;

    public function getNewPassword(): string;

    public function getNewPasswordConfirmation(): string;
}
