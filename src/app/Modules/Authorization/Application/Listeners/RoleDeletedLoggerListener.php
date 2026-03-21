<?php

namespace App\Modules\Authorization\Application\Listeners;

use App\Modules\Authorization\Domain\Events\RoleDeleted;
use App\Shared\Logging\LoggerInterface;

final class RoleDeletedLoggerListener
{
    public function __construct(private LoggerInterface $logger) {}

    public function handle(RoleDeleted $event): void 
    {
        try {
            $this->logger->write(
                'info',
                'delete',
                "Người dùng {$event->actor_id} đã xóa vai trò {$event->id}",
                $event->actor_id,
                [
                    'role_id' => $event->id,
                    'role_name' => $event->name
                ]
            );
        } catch (\Throwable $e) {
        }
    }
}