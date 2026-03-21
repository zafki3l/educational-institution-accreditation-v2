<?php

namespace App\Modules\Authorization\Application\Listeners;

use App\Modules\Authorization\Domain\Events\RoleCreated;
use App\Shared\Logging\LoggerInterface;

final class RoleCreatedLoggerListener
{
    public function __construct(private LoggerInterface $logger) {}

    public function handle(RoleCreated $event): void 
    {
        try {
            $this->logger->write(
                'info',
                'create',
                "Người dùng {$event->actor_id} đã tạo 1 vai trò mới",
                $event->actor_id,
                [
                    'role_name' => $event->name
                ]
            );
        } catch (\Throwable $e) {
        }
    }
}