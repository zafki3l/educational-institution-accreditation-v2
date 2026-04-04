<?php

namespace App\Modules\QualityAssessment\Infrastructure\ListenerProvider;

use App\Modules\QualityAssessment\Application\Listeners\Milestone\MilestoneCreatedLoggerListener;
use App\Modules\QualityAssessment\Application\Listeners\Milestone\MilestoneDeletedLoggerListener;
use App\Modules\QualityAssessment\Domain\Events\Milestone\MilestoneCreated;
use App\Modules\QualityAssessment\Domain\Events\Milestone\MilestoneDeleted;
use Core\ListenerProvider;

final class MilestoneListenerProvider extends ListenerProvider
{
    public static function register(): array
    {
        return [
            MilestoneCreated::class => [MilestoneCreatedLoggerListener::class],
            MilestoneDeleted::class => [MilestoneDeletedLoggerListener::class]
        ];
    }
}