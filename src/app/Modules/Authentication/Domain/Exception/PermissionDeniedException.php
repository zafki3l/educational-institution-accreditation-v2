<?php

namespace App\Modules\Authentication\Domain\Exception;

use App\Shared\Domain\Exception\DomainException;

final class PermissionDeniedException extends DomainException
{
    public function __construct()
    {
        return parent::__construct("Permission denied!", "PERMISSION_DENIED");
    }
}