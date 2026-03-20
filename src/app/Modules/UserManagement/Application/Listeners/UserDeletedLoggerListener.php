<?php

namespace App\Modules\UserManagement\Application\Listeners;

use App\Modules\UserManagement\Domain\Events\UserDeleted;
use App\Shared\Logging\LoggerInterface;

final class UserDeletedLoggerListener
{
    public function __construct(private LoggerInterface $logger) {}

    public function handle(UserDeleted $event): void 
    {
        try {
            $this->logger->write(
                'info',
                'update',
                "Người dùng {$event->actor_id} đã xóa người dùng {$event->user_id}",
                $event->actor_id,
                ['id' => $event->user_id]
            );
        } catch (\Throwable $e) {
            error_log("MongoDB is down, skipping log: " . $e->getMessage());
            return;
        }
    }
}