<?php

namespace App\Modules\UserManagement\Application\UseCases;

use App\Modules\UserManagement\Application\Requests\UpdateUserRequestInterface;
use App\Modules\UserManagement\Domain\Events\UserUpdated;
use App\Modules\UserManagement\Domain\Repositories\UserRepositoryInterface;
use App\Modules\UserManagement\Domain\ValueObjects\Email;
use App\Shared\Events\EventDispatcherInterface;

final class UpdateUserUseCase
{
    public function __construct(
        private UserRepositoryInterface $repository,
        private EventDispatcherInterface $eventDispatcher
    ) {}

    public function execute(UpdateUserRequestInterface $request, string $actor_id)
    {
        $user = $this->repository->findOrFail($request->getId());

        $user->update(
            $request->getFirstName(), 
            $request->getLastName(), 
            Email::fromString($request->getEmail()), 
            $request->getRoleId(),
            $request->getDepartmentId() == '' ? null : $request->getDepartmentId()
        );

        $this->repository->update($user);

        $this->eventDispatcher->dispatch(new UserUpdated(
            $user->getUserId()->value(), 
            $user->getChanges(),
            $actor_id
        ));
    }
}