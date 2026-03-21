<?php

namespace App\Modules\Authentication\Application\Listeners;

use App\Modules\Authentication\Domain\Events\UserLoginFailed;
use App\Shared\Logging\LoggerInterface;

final class UserLoginFailedLoggerListener
{
    public function __construct(private LoggerInterface $logger) {}

    public function handle(UserLoginFailed $event): void 
    {
        try {
            $this->logger->write(
                'info',
                'login',
                "Người dùng {$event->identifier} đã đăng nhập vào hệ thống thất bại",
                '',
                [
                    'user_id' => $event->identifier
                ]
            );
        } catch (\Throwable $e) {
        }
    }
}