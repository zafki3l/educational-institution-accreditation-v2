<?php

namespace App\Modules\QualityAssessment\Infrastructure\ListenerProvider;

use App\Modules\QualityAssessment\Application\Listeners\Standard\StandardCreatedLoggerListener;
use App\Modules\QualityAssessment\Application\Listeners\Standard\StandardDeletedLoggerListener;
use App\Modules\QualityAssessment\Application\Listeners\Standard\StandardUpdatedLoggerListener;
use App\Modules\QualityAssessment\Domain\Events\Standard\StandardCreated;
use App\Modules\QualityAssessment\Domain\Events\Standard\StandardDeleted;
use App\Modules\QualityAssessment\Domain\Events\Standard\StandardUpdated;
use Core\ListenerProvider;

final class StandardListenerProvider extends ListenerProvider
{
    public static function register(): array
    {
        return [
            StandardCreated::class => [StandardCreatedLoggerListener::class],
            StandardDeleted::class => [StandardDeletedLoggerListener::class],
            StandardUpdated::class => [StandardUpdatedLoggerListener::class]
        ];
    }
}