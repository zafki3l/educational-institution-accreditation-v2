<?php

namespace App\Shared\Security\Csrf;

class CsrfTokenGenerator
{
    public static function generate(): void
    {
        if (empty($_SESSION['CSRF-token']) || time() >= ($_SESSION['token-expire'] ?? 0)) {
            $_SESSION['CSRF-token'] = bin2hex(random_bytes(32));
            $_SESSION['token-expire'] = time() + 3600;
        }
    }
}