<?php

namespace App\Modules\UserManagement\Domain\Exception;

use App\Shared\Domain\Exception\DomainException;

final class EmailEmptyException extends DomainException
{
    public function __construct()
    {
        parent::__construct(
            'Email không được bỏ trống!', 
            "EMAIL_EMPTY"
        );
    }
}