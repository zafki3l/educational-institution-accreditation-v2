<?php

namespace App\Modules\DepartmentManagement\Application\Listeners;

use App\Modules\DepartmentManagement\Domain\Events\DepartmentDeleted;
use App\Shared\Logging\LoggerInterface;

final class DepartmentDeletedLoggerListener
{
    public function __construct(private LoggerInterface $logger) {}

    public function handle(DepartmentDeleted $event): void 
    {
        try {
            $this->logger->write(
                'info',
                'delete',
                "Người dùng {$event->actor_id} đã xóa phòng ban {$event->id}",
                $event->actor_id,
                [
                    'department_id' => $event->id,
                    'department_name' => $event->name
                ]
            );
        } catch (\Throwable $e) {
        }
    }
}