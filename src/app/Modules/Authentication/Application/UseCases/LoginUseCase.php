<?php

namespace App\Modules\Authentication\Application\UseCases;

use App\Modules\Authentication\Application\Requests\LoginRequestInterface;
use App\Modules\Authentication\Application\Responses\LoginResponse;
use App\Modules\Authentication\Domain\Events\UserLoggedIn;
use App\Modules\Authentication\Domain\Events\UserLoginFailed;
use App\Modules\Authentication\Domain\Repositories\AuthenticableUserRepositoryInterface;
use App\Modules\UserManagement\Domain\ValueObjects\Password;
use App\Shared\Contracts\Events\EventDispatcherInterface;

final class LoginUseCase
{
    /**
     * Using fake hash to prevents timing attacks
     * @var string
     */
    private const DUMMY_HASH = '$2y$10$usesomesillystringfore7hnbRJHxXVLeakoG8K30oukPsA.ztMG';

    public function __construct(
        private AuthenticableUserRepositoryInterface $repository,
        private EventDispatcherInterface $eventDispatcher
    ) {}

    public function execute(LoginRequestInterface $request): ?LoginResponse
    {
        $identifier = strtolower($request->getIdentifier());
        $authUser = $this->repository->findByIdentifier($identifier);
        
        $password = $authUser 
            ? $authUser->getPassword()
            : Password::fromHash(self::DUMMY_HASH);

        $isVerify = $password->verify($request->getPassword());

        if (!$isVerify || !$authUser) {
            $this->eventDispatcher->dispatch(new UserLoginFailed($identifier));

            return null;
        }

        $this->eventDispatcher->dispatch(new UserLoggedIn($authUser->getUserId()->value()));

        return new LoginResponse(
            $authUser->getUserId()->value(),
            $authUser->getIdentifier(),
            $authUser->getRoleId()
        );
    }
}
