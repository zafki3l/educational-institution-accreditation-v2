<?php

namespace App\Modules\QualityAssessment\Application\Listeners\Standard;

use App\Modules\QualityAssessment\Domain\Events\Standard\StandardDeleted;
use App\Shared\Contracts\Logging\LoggerInterface;

final class StandardDeletedLoggerListener
{
    public function __construct(private LoggerInterface $logger) {}

    public function handle(StandardDeleted $event): void 
    {
        try {
            $this->logger->write(
                'info',
                'delete',
                "Người dùng {$event->actor_id} xóa tiêu chuẩn {$event->id}",
                $event->actor_id,
                [
                    'standard_id' => $event->id,
                    'standard_name' => $event->name,
                    'department_id' => $event->department_id
                ]
            );
        } catch (\Throwable $e) {
        }
    }
}