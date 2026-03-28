<?php

namespace App\Modules\Authentication\Presentation\Controllers;

use App\Modules\Authentication\Application\UseCases\LoginUseCase;
use App\Modules\Authentication\Presentation\Requests\LoginRequest;
use App\Shared\SessionManager\AuthSession;
use App\Shared\Web\Responses\ViewResponse;

final class LoginController extends AuthController
{
    public function __construct(private LoginUseCase $loginUseCase) {}

    public function showLogin(): ViewResponse
    {
        if (isAuth()) {
            $this->redirect('/');
        }

        return new ViewResponse(
            self::MODULE_NAME,
            'login/main',
            'login.layouts',
            [
                'title' => 'Đăng nhập | ' . SYSTEM_NAME
            ]
        );
    }

    public function login(LoginRequest $request): void
    {
        $auth_user = $this->loginUseCase->execute($request);

        if (!$auth_user) {
            $_SESSION['login_errors'] = 'Tài khoản hoặc mật khẩu không hợp lệ!';

            $this->redirect(HOST . '/login');
        }

        session_regenerate_id(true);

        AuthSession::set([
            'user_id' => $auth_user->user_id,
            'identifier' => $auth_user->identifier,
            'role_id' => $auth_user->role_id
        ]);

        if (isAdmin()) {
            $this->redirect('/admin/dashboard');
        } else if (isStaff()) {
            $this->redirect('/staff/dashboard');
        } else {
            $this->redirect('/');
        }
    }
}