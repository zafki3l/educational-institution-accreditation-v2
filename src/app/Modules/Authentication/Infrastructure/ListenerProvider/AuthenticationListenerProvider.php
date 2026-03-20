<?php

namespace App\Modules\Authentication\Infrastructure\ListenerProvider;

use App\Modules\Authentication\Application\Listeners\UserLoggedInLoggerListener;
use App\Modules\Authentication\Application\Listeners\UserLoggedOutLoggerListener;
use App\Modules\Authentication\Application\Listeners\UserLoginFailedLoggerListener;
use App\Modules\Authentication\Domain\Events\UserLoggedIn;
use App\Modules\Authentication\Domain\Events\UserLoggedOut;
use App\Modules\Authentication\Domain\Events\UserLoginFailed;
use Core\ListenerProvider;

final class AuthenticationListenerProvider extends ListenerProvider
{
    public static function register(): array
    {
        return [
            UserLoggedIn::class => [UserLoggedInLoggerListener::class],
            UserLoginFailed::class => [UserLoginFailedLoggerListener::class],
            UserLoggedOut::class => [UserLoggedOutLoggerListener::class]
        ];
    }
}