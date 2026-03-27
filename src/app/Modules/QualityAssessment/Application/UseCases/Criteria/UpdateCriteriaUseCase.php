<?php

namespace App\Modules\QualityAssessment\Application\UseCases\Criteria;

use App\Modules\QualityAssessment\Application\Requests\Criteria\UpdateCriteriaRequestInterface;
use App\Modules\QualityAssessment\Domain\Repositories\CriteriaRepositoryInterface;
use App\Shared\Logging\LoggerInterface;

final class UpdateCriteriaUseCase
{
    public function __construct(
        private CriteriaRepositoryInterface $repository,
        private LoggerInterface $logger,
    ) {}

    public function execute(UpdateCriteriaRequestInterface $request, string $actor_id): void
    {
        $criteria = $this->repository->findOrFail($request->getId());

        $criteria->update(
            $request->getStandardId(),
            $request->getName()
        );

        $this->repository->save($criteria);

        $this->writeLog($request, $actor_id);
    }

    private function writeLog(UpdateCriteriaRequestInterface $request, string $actor_id): void
    {
        $this->logger->write(
            'info',
            'update', 
            "Người dùng {$actor_id} đã cập nhật tiêu chí {$request->getId()}", 
            $actor_id, 
            [
                'id' => $request->getId(),
                'name' => $request->getName(),
                'standard_id' => $request->getStandardId()
            ]
        );
    }
}