<?php

namespace App\Modules\QualityAssessment\Application\Listeners\Evidence;

use App\Modules\QualityAssessment\Domain\Events\Evidence\EvidenceCreated;
use App\Shared\Contracts\Logging\LoggerInterface;

final class EvidenceCreatedLoggerListener
{
    public function __construct(private LoggerInterface $logger) {}

    public function handle(EvidenceCreated $event): void 
    {
        try {
            $this->logger->write(
                'info',
                'create',
                "Người dùng {$event->actor_id} thêm một minh chứng mới",
                $event->actor_id,
                [
                    'evidence_id' => $event->id,
                    'evidence_name' => $event->name,
                    'document_number' => $event->document_number ? $event->document_number : '',
                    'issued_date' => $event->issued_date ? $event->issued_date : '',
                    'issuing_authority' => $event->issuing_authority,
                    'file_url' => $event->file_url ? $event->file_url : '',
                    'milestone_code' => $event->milestone_code,
                ]
            );
        } catch (\Throwable $e) {
        }
    }
}