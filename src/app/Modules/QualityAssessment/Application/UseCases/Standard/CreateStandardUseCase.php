<?php

namespace App\Modules\QualityAssessment\Application\UseCases\Standard;

use App\Modules\QualityAssessment\Application\Requests\Standard\CreateStandardRequestInterface;
use App\Modules\QualityAssessment\Domain\Entities\Standard;
use App\Modules\QualityAssessment\Domain\Events\Standard\StandardCreated;
use App\Modules\QualityAssessment\Domain\Repositories\StandardRepositoryInterface;
use App\Shared\Contracts\Events\EventDispatcherInterface;
use App\Shared\Contracts\UnitOfWork\UnitOfWorkInterface;

final class CreateStandardUseCase
{
    public function __construct(
        private StandardRepositoryInterface $repository,
        private EventDispatcherInterface $eventDispatcher,
        private UnitOfWorkInterface $unitOfWork
    ) {}

    public function execute(CreateStandardRequestInterface $request, string $actor_id): void
    {
        $standard = Standard::create(
            $request->getId(),
            $request->getName(),
            $request->getDepartmentId()
        );

        $this->unitOfWork->execute(function () use ($standard, $actor_id) {
            $this->repository->create($standard);

            $this->eventDispatcher->dispatch(new StandardCreated(
                $standard->getId(),
                $standard->getName(),
                $standard->getDepartmentId(),
                $actor_id
            ));
        });
    }
}