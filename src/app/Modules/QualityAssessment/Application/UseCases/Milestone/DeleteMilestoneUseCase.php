<?php

namespace App\Modules\QualityAssessment\Application\UseCases\Milestone;

use App\Modules\QualityAssessment\Domain\Events\Milestone\MilestoneDeleted;
use App\Modules\QualityAssessment\Domain\Repositories\MilestoneRepositoryInterface;
use App\Shared\Contracts\Events\EventDispatcherInterface;
use App\Shared\Contracts\UnitOfWork\UnitOfWorkInterface;

final class DeleteMilestoneUseCase
{
    public function __construct(
        private MilestoneRepositoryInterface $repository,
        private EventDispatcherInterface $eventDispatcher,
        private UnitOfWorkInterface $unitOfWork
    ) {}

    public function execute(int $id, string $actor_id): void
    {
        $milestone = $this->repository->findOrFail($id);
        
        $this->unitOfWork->execute(function () use ($milestone, $actor_id) {
            $this->repository->delete($milestone);

            $this->eventDispatcher->dispatch(new MilestoneDeleted(
                $milestone->getId(),
                $milestone->getCriteriaId(),
                $milestone->getCode()->value(),
                $milestone->getOrder(),
                $milestone->getName(),
                $actor_id
            ));
        });
    }
}