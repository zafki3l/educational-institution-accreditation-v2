<?php

namespace App\Modules\UserManagement\Domain\Exception;

use App\Shared\Domain\Exception\DomainException;

final class UserNameEmptyException extends DomainException
{
    public function __construct()
    {
        parent::__construct("Vui lòng nhập đầy đủ họ và tên!", "EMPTY_USERNAME");
    }
}