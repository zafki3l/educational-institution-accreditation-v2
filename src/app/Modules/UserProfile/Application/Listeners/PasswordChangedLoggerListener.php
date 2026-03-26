<?php

namespace App\Modules\UserProfile\Application\Listeners;

use App\Modules\UserProfile\Domain\Events\PasswordChanged;
use App\Shared\Logging\LoggerInterface;

final class PasswordChangedLoggerListener
{
    public function __construct(private LoggerInterface $logger) {}

    public function handle(PasswordChanged $event): void 
    {
        try {
            $this->logger->write(
                'info',
                'update',
                "Người dùng {$event->actor_id} đã thay đổi mật khẩu của mình",
                $event->actor_id,
                [
                    'user_id' => $event->actor_id,
                ]
            );
        } catch (\Throwable $e) {
        }
    }
}