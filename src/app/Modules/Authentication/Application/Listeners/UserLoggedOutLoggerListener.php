<?php

namespace App\Modules\Authentication\Application\Listeners;

use App\Modules\Authentication\Domain\Events\UserLoggedOut;
use App\Shared\Logging\LoggerInterface;

final class UserLoggedOutLoggerListener
{
    public function __construct(private LoggerInterface $logger) {}

    public function handle(UserLoggedOut $event): void 
    {
        try {
            $this->logger->write(
                'info',
                'login',
                "Người dùng {$event->authenticable_user_id} đã đăng xuất khỏi hệ thống",
                $event->authenticable_user_id,
                [
                    'id' => $event->authenticable_user_id
                ]
            );
        } catch (\Throwable $e) {
            error_log("MongoDB is down, skipping log: " . $e->getMessage());
            return;
        }
    }
}