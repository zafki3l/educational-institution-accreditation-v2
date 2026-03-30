<?php

namespace App\Modules\QualityAssessment\Application\Listeners\Standard;

use App\Modules\QualityAssessment\Domain\Events\Standard\StandardUpdated;
use App\Shared\Contracts\Logging\LoggerInterface;

final class StandardUpdatedLoggerListener
{
    public function __construct(private LoggerInterface $logger) {}

    public function handle(StandardUpdated $event): void 
    {
        try {
            $this->logger->write(
                'info',
                'update',
                "Người dùng {$event->actor_id} cập nhật tiêu chuẩn {$event->id}",
                $event->actor_id,
                [
                    'standard_id' => $event->id,
                    'changes' => $event->changes
                ]
            );
        } catch (\Throwable $e) {
        }
    }
}