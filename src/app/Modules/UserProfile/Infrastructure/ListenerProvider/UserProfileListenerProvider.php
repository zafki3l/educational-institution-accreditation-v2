<?php

namespace App\Modules\UserProfile\Infrastructure\ListenerProvider;

use App\Modules\UserProfile\Application\Listeners\PasswordChangedLoggerListener;
use App\Modules\UserProfile\Application\Listeners\UserProfileUpdatedLoggerListener;
use App\Modules\UserProfile\Domain\Events\PasswordChanged;
use App\Modules\UserProfile\Domain\Events\UserProfileUpdated;
use Core\ListenerProvider;

final class UserProfileListenerProvider extends ListenerProvider
{
    public static function register(): array
    {
        return [
            PasswordChanged::class => [PasswordChangedLoggerListener::class],
            UserProfileUpdated::class => [UserProfileUpdatedLoggerListener::class]
        ];
    }
}