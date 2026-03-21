<?php

namespace App\Modules\DepartmentManagement\Application\Listeners;

use App\Modules\DepartmentManagement\Domain\Events\DepartmentCreated;
use App\Shared\Logging\LoggerInterface;

final class DepartmentCreatedLoggerListener
{
    public function __construct(private LoggerInterface $logger) {}

    public function handle(DepartmentCreated $event): void 
    {
        try {
            $this->logger->write(
                'info',
                'create',
                "Người dùng {$event->actor_id} đã tạo 1 phòng ban mới",
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