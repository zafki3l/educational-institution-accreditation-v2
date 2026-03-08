<?php

namespace App\Modules\UserProfile\Domain\Exceptions;

use App\Shared\Exception\DomainException;

class NewPasswordNotMatchingException extends DomainException
{
    public function __construct()
    {
        parent::__construct(
            "Mật khẩu mới không khớp, vui lòng nhập lại!",
            "PASSWORD_NOT_MATCH",
        );
    }
}