<?php

namespace App\Modules\UserManagement\Application\Listeners;

use App\Modules\UserManagement\Domain\Events\UserUpdated;
use App\Shared\Logging\LoggerInterface;

final class UserUpdatedLoggerListener
{
    public function __construct(private LoggerInterface $logger) {}

    public function handle(UserUpdated $event): void 
    {
        try {
            $this->logger->write(
                'info',
                'update',
                "Người dùng {$event->actor_id} đã sửa thông tin người dùng {$event->user_id}",
                $event->actor_id,
                [
                    'id' => $event->user_id,
                    'changes' => $event->changes
                ]
            );
        } catch (\Throwable $e) {
        }
    }
}