<?php

namespace App\Modules\QualityAssessment\Application\Listeners\Milestone;

use App\Modules\QualityAssessment\Domain\Events\Milestone\MilestoneDeleted;
use App\Shared\Contracts\Logging\LoggerInterface;

final class MilestoneDeletedLoggerListener
{
    public function __construct(private LoggerInterface $logger) {}

    public function handle(MilestoneDeleted $event): void 
    {
        try {
            $this->logger->write(
                'info',
                'delete',
                "Người dùng {$event->actor_id} xóa mốc đánh giá {$event->code}",
                $event->actor_id,
                [
                    'milestone_id' => $event->id,
                    'criteria_id' => $event->criteria_id,
                    'milestone_code' => $event->code,
                    'milestone_order' => $event->order,
                    'milestone_name' => $event->name,
                ]
            );
        } catch (\Throwable $e) {
        }
    }
}