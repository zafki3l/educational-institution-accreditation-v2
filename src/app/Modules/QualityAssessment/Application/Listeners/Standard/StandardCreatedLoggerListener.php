<?php

namespace App\Modules\QualityAssessment\Application\Listeners\Standard;

use App\Modules\QualityAssessment\Domain\Events\Standard\StandardCreated;
use App\Shared\Contracts\Logging\LoggerInterface;

final class StandardCreatedLoggerListener
{
    public function __construct(private LoggerInterface $logger) {}

    public function handle(StandardCreated $event): void 
    {
        try {
            $this->logger->write(
                'info',
                'create',
                "Người dùng {$event->actor_id} thêm một tiêu chuẩn mới",
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