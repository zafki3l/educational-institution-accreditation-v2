<?php

namespace App\Modules\QualityAssessment\Application\Listeners\Evidence;

use App\Modules\QualityAssessment\Domain\Events\Evidence\EvidenceUpdated;
use App\Shared\Contracts\Logging\LoggerInterface;

final class EvidenceUpdatedLoggerListener
{
    public function __construct(private LoggerInterface $logger) {}

    public function handle(EvidenceUpdated $event): void 
    {
        try {
            $this->logger->write(
                'info',
                'update',
                "Người dùng {$event->actor_id} sửa minh chứng {$event->id}",
                $event->actor_id,
                [
                    'id' => $event->id,
                    'changes' => $event->changes
                ]
            );
        } catch (\Throwable $e) {
        }
    }
}