<?php

namespace App\Modules\UserManagement\Domain\Exception;

use App\Shared\Domain\Exception\DomainException;

final class PasswordEmptyException extends DomainException
{
    public function __construct()
    {
        return parent::__construct("Mật khẩu không được để trống!", "PASSWORD_EMPTY");
    }
}