<?php

namespace App\Modules\QualityAssessment\Infrastructure\ListenerProvider;

use App\Modules\QualityAssessment\Application\Listeners\Evidence\EvidenceCreatedLoggerListener;
use App\Modules\QualityAssessment\Application\Listeners\Evidence\EvidenceDeletedLoggerListener;
use App\Modules\QualityAssessment\Application\Listeners\Evidence\EvidenceUpdatedLoggerListener;
use App\Modules\QualityAssessment\Domain\Events\Evidence\EvidenceCreated;
use App\Modules\QualityAssessment\Domain\Events\Evidence\EvidenceDeleted;
use App\Modules\QualityAssessment\Domain\Events\Evidence\EvidenceUpdated;
use Core\ListenerProvider;

final class EvidenceListenerProvider extends ListenerProvider
{
    public static function register(): array
    {
        return [
            EvidenceCreated::class => [EvidenceCreatedLoggerListener::class],
            EvidenceDeleted::class => [EvidenceDeletedLoggerListener::class],
            EvidenceUpdated::class => [EvidenceUpdatedLoggerListener::class]
        ];
    }
}