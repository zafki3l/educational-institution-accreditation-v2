<?php

namespace App\Modules\QualityAssessment\Application\UseCases\Milestone;

use App\Modules\QualityAssessment\Application\Requests\Milestone\CreateMilestoneRequestInterface;
use App\Modules\QualityAssessment\Domain\Entities\Milestone;
use App\Modules\QualityAssessment\Domain\Events\Milestone\MilestoneCreated;
use App\Modules\QualityAssessment\Domain\Repositories\MilestoneRepositoryInterface;
use App\Modules\QualityAssessment\Domain\ValueObjects\Milestone\MilestoneCode;
use App\Shared\Contracts\Events\EventDispatcherInterface;
use App\Shared\Contracts\UnitOfWork\UnitOfWorkInterface;

final class CreateMilestoneUseCase
{
    public function __construct(
        private MilestoneRepositoryInterface $repository,
        private EventDispatcherInterface $eventDispatcher,
        private UnitOfWorkInterface $unitOfWork
    ) {}

    public function execute(CreateMilestoneRequestInterface $request, string $actor_id): Milestone
    {
        return $this->unitOfWork->execute(function () use ($request, $actor_id) {
            $milestone = $this->repository->create(Milestone::create(
                null,
                $request->getCriteriaId(),
                MilestoneCode::generate($request->getCriteriaId(), $request->getOrder()),
                $request->getOrder(),
                $request->getName()
            ));

            $this->eventDispatcher->dispatch(new MilestoneCreated(
                $milestone->getId(),
                $milestone->getCriteriaId(),
                $milestone->getCode()->value(),
                $milestone->getOrder(),
                $milestone->getName(),
                $actor_id
            ));

            return $milestone;
        });
    }
}