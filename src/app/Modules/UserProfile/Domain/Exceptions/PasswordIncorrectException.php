<?php

namespace App\Modules\UserProfile\Domain\Exceptions;

use App\Shared\Domain\Exception\DomainException;

class PasswordIncorrectException extends DomainException
{
    public function __construct()
    {
        parent::__construct(
            "Mật khẩu cũ không đúng, vui lòng nhập lại!",
            "INCORRECT_PASSWORD",
        );
    }
}