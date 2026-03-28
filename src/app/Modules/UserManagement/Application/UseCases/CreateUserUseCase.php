<?php

namespace App\Modules\UserManagement\Application\UseCases;

use App\Modules\UserManagement\Application\Requests\CreateUserRequestInterface;
use App\Modules\UserManagement\Domain\Entities\User;
use App\Modules\UserManagement\Domain\Events\UserCreated;
use App\Modules\UserManagement\Domain\Exception\EmailExistException;
use App\Modules\UserManagement\Domain\Repositories\UserRepositoryInterface;
use App\Modules\UserManagement\Domain\Services\EmailExistsCheckerInterface;
use App\Modules\UserManagement\Domain\ValueObjects\Email;
use App\Modules\UserManagement\Domain\ValueObjects\Password;
use App\Modules\UserManagement\Domain\ValueObjects\UserId;
use App\Shared\Contracts\Events\EventDispatcherInterface;
use App\Shared\Infrastructure\Utils\UuidGenerator;

final class CreateUserUseCase
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private EmailExistsCheckerInterface $emailExistsChecker,
        private EventDispatcherInterface $EventDispatcher
    ) {}

    public function execute(CreateUserRequestInterface $request, string $actor_id): void
    {
        $email = Email::fromString($request->getEmail());

        if ($this->emailExistsChecker->isExists($email)) {
            throw new EmailExistException();
        }
        
        $user = User::create(
            UserId::fromString(UuidGenerator::v4()),
            $request->getFirstName(),
            $request->getLastName(),
            $email,
            Password::fromPlain($request->getPassword()),
            $request->getRoleId(),
            $request->getDepartmentId()
        );

        $this->userRepository->create($user);

        $this->EventDispatcher->dispatch(new UserCreated(
            $user->getUserId()->value(), 
            $actor_id
        ));
    }
}