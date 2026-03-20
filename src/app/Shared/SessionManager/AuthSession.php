<?php

namespace App\Shared\SessionManager;

class AuthSession
{
    /**
     * Set the login user when they are successfully log-in
     * @param array $db_user
     * @return array{department_id: mixed, email: mixed, first_name: mixed, gender: mixed, last_name: mixed, role_id: mixed, user_id: mixed}
     */
    public static function set(array $data = []): void
    {
        $_SESSION['auth_user'] = $data; 
    }

    public function authUser(): ?SessionAuthUser
    {
        if (!isset($_SESSION['auth_user'])) {
            return null;
        }

        return new SessionAuthUser(
            $_SESSION['auth_user']['user_id'],
            $_SESSION['auth_user']['identifier'],
            $_SESSION['auth_user']['role_id']
        );
    }

    public static function getUserId(): string
    {
        return $_SESSION['auth_user']['user_id'];
    }

    public function clear(): void
    {
        $_SESSION = [];

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        session_regenerate_id(true);
        session_destroy();
    }
}