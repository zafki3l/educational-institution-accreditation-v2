<?php

namespace App\Modules\UserProfile\Domain\Exceptions;

use App\Shared\Exception\DomainException;

final class UserNameEmptyException extends DomainException
{
    public function __construct()
    {
        parent::__construct("Vui lòng nhập đầy đủ họ và tên!", "EMPTY_USERNAME");
    }
}