<?php

namespace App\Modules\QualityAssessment\Application\Listeners\Milestone;

use App\Modules\QualityAssessment\Domain\Events\Milestone\MilestoneCreated;
use App\Shared\Contracts\Logging\LoggerInterface;

final class MilestoneCreatedLoggerListener
{
    public function __construct(private LoggerInterface $logger) {}

    public function handle(MilestoneCreated $event): void 
    {
        try {
            $this->logger->write(
                'info',
                'create',
                "Người dùng {$event->actor_id} thêm một mốc đánh giá mới",
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