<?php

namespace App\Modules\Authorization\Domain\Exception;

use App\Shared\Domain\Exception\DomainException;

final class EmptyRoleNameException extends DomainException
{
    public function __construct()
    {
        parent::__construct(
            "Không được bỏ trống role name!",
            'ROLE_NAME_EMPTY',
            404
        );
    }
}