<?php

namespace App\Modules\Authorization\Application\Listeners;

use App\Modules\Authorization\Domain\Events\RoleUpdated;
use App\Shared\Logging\LoggerInterface;

final class RoleUpdatedLoggerListener
{
    public function __construct(private LoggerInterface $logger) {}

    public function handle(RoleUpdated $event): void 
    {
        try {
            $this->logger->write(
                'info',
                'update',
                "Người dùng {$event->actor_id} đã cập nhật vai trò {$event->id}",
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