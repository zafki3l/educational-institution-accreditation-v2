<?php

namespace App\Shared\Security\Session;

class SessionGenerator
{
    /**
     * Regenerate session if it isn't active
     * @return bool
     */
    public static function generate(): bool
    {
        return session_status() == PHP_SESSION_NONE ? session_start() : true;
    }
}