<?php

namespace App\Modules\Authentication\Application\Listeners;

use App\Modules\Authentication\Domain\Events\UserLoggedIn;
use App\Shared\Logging\LoggerInterface;

final class UserLoggedInLoggerListener
{
    public function __construct(private LoggerInterface $logger) {}

    public function handle(UserLoggedIn $event): void 
    {
        try {
            $this->logger->write(
                'info',
                'login',
                "Người dùng {$event->authenticable_user_id} đã đăng nhập vào hệ thống thành công",
                $event->authenticable_user_id,
                [
                    'user_id' => $event->authenticable_user_id,
                ]
            );
        } catch (\Throwable $e) {
        }
    }
}