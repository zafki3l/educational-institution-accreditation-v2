<?php

namespace App\Modules\QualityAssessment\Application\UseCases\Standard;

use App\Modules\QualityAssessment\Application\Requests\Standard\UpdateStandardRequestInterface;
use App\Modules\QualityAssessment\Domain\Events\Standard\StandardUpdated;
use App\Modules\QualityAssessment\Domain\Repositories\StandardRepositoryInterface;
use App\Shared\Contracts\Events\EventDispatcherInterface;
use App\Shared\Contracts\UnitOfWork\UnitOfWorkInterface;

final class UpdateStandardUseCase
{
    public function __construct(
        private StandardRepositoryInterface $repository,
        private EventDispatcherInterface $eventDispatcher,
        private UnitOfWorkInterface $unitOfWork
    ) {}

    public function execute(UpdateStandardRequestInterface $request, string $actor_id): void
    {
        $standard = $this->repository->findOrFail($request->getId());

        if (!$standard) {
            return;
        }

        $standard->update($request->getName(), $request->getDepartmentId());

        if (!$standard->hasChanges()) {
            return;
        }

        $this->unitOfWork->execute(function () use ($standard, $actor_id) {
            $this->repository->update($standard);

            $this->eventDispatcher->dispatch(new StandardUpdated(
                $standard->getId(),
                $standard->getChanges(),
                $actor_id
            ));
        });
    }
}