<?php

namespace App\Modules\QualityAssessment\Application\UseCases\Evidence;

use App\Modules\QualityAssessment\Domain\Repositories\EvidenceRepositoryInterface;
use App\Shared\Logging\LoggerInterface;

final class DeleteEvidenceUseCase
{
    public function __construct(
        private EvidenceRepositoryInterface $repository,
        private LoggerInterface $logger
    ) {}

    public function execute(string $id, string $actor_id): string
    {
        $criteria_id = $this->repository->delete($id);

        $this->writeLog($id, $criteria_id, $actor_id);

        return $criteria_id;
    }

    private function writeLog(string $id, string $criteria_id, string $actor_id): void
    {
        $this->logger->write(
            'info',
            'delete', 
            "Người dùng {$actor_id} đã xóa 1 minh chứng. Mã minh chứng: {$id}", 
            $actor_id, 
            [
                'id' => $id,
                'criteria_id' => $criteria_id
            ]
        );
    }
}