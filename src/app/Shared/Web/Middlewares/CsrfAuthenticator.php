<?php

namespace App\Shared\Web\Middlewares;

use Exception;

final class CsrfAuthenticator
{
    public function handle(): void
    {
        if (!isset($_SESSION['CSRF-token'])) {
            throw new Exception('Session token missing!');
        }

        $sessionToken = (string) $_SESSION['CSRF-token'];

        $headerToken = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? null;
        $formToken   = $_POST['CSRF-token'] ?? null;

        $token = $headerToken ?? $formToken;

        if (!$token) {
            throw new Exception('Token is not set!');
        }

        if (!$this->verifyToken($sessionToken, $token)) {
            throw new Exception('Token invalid! Please reload page!');
        }

        if ($this->isTokenExpire()) {
            throw new Exception('Token expired!');
        }
    }

    private function verifyToken(string $sessionToken, string $token): bool
    {
        return hash_equals($sessionToken, $token);
    }

    private function isTokenExpire(): bool
    {
        return isset($_SESSION['token-expire'])
            && time() >= $_SESSION['token-expire'];
    }
}
