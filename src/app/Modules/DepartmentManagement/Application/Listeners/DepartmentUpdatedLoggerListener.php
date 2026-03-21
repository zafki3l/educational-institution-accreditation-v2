<?php

namespace App\Modules\DepartmentManagement\Application\Listeners;

use App\Modules\DepartmentManagement\Domain\Events\DepartmentUpdated;
use App\Shared\Logging\LoggerInterface;

final class DepartmentUpdatedLoggerListener
{
    public function __construct(private LoggerInterface $logger) {}

    public function handle(DepartmentUpdated $event): void 
    {
        try {
            $this->logger->write(
                'info',
                'delete',
                "Người dùng {$event->actor_id} đã cập nhật phòng ban {$event->id}",
                $event->actor_id,
                [
                    'department_id' => $event->id,
                    'department_old_name' => $event->old_name,
                    'department_new_name' => $event->new_name
                ]
            );
        } catch (\Throwable $e) {
        }
    }
}