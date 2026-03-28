<?php

namespace App\Modules\UserManagement\Domain\Exception;

use App\Shared\Domain\Exception\DomainException;

final class PasswordTooShortException extends DomainException
{
    public function __construct()
    {
        parent::__construct('Mật khẩu quá ngắn! Tối thiểu 8 ký tự!', "PASSWORD_TOO_SHORT");
    }
}