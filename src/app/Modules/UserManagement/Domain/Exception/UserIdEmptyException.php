<?php

namespace App\Modules\UserManagement\Domain\Exception;

use App\Shared\Domain\Exception\DomainException;

final class UserIdEmptyException extends DomainException
{
    public function __construct()
    {
        parent::__construct("User Id đang trống!", "EMPTY_USER_ID");
    }
}