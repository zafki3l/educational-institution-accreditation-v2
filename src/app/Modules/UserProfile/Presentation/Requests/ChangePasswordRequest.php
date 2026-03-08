<?php

namespace App\Modules\UserProfile\Presentation\Requests;

use App\Modules\UserProfile\Application\Requests\ChangePasswordRequestInterface;

final class ChangePasswordRequest implements ChangePasswordRequestInterface
{
    private string $current_password;
    private string $new_password;
    private string $new_password_confirmation;

    public function __construct()
    {
        $this->current_password = $_POST['current_password'];
        $this->new_password = $_POST['new_password'];
        $this->new_password_confirmation = $_POST['new_password_confirmation'];
    }

    public function getCurrentPassword(): string
    {
        return $this->current_password;
    }

    public function getNewPassword(): string
    {
        return $this->new_password;
    }

    public function getNewPasswordConfirmation(): string
    {
        return $this->new_password_confirmation;
    }
}
