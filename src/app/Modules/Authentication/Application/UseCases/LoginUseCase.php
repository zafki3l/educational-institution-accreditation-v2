<?php

namespace App\Modules\Authentication\Application\UseCases;

use App\Modules\Authentication\Application\Requests\LoginRequestInterface;
use App\Modules\Authentication\Domain\Entities\AuthenticableUser;
use App\Modules\Authentication\Domain\Repositories\AuthenticableUserRepositoryInterface;
use App\Modules\UserManagement\Domain\ValueObjects\Password;

final class LoginUseCase
{
    /**
     * Using fake hash to prevents timing attacks
     * @var string
     */
    private const DUMMY_HASH = '$2y$10$usesomesillystringfore7hnbRJHxXVLeakoG8K30oukPsA.ztMG';

    public function __construct(private AuthenticableUserRepositoryInterface $repository) {}

    public function execute(LoginRequestInterface $request): ?AuthenticableUser
    {
        $identifier = strtolower($request->getIdentifier());
        $authUser = $this->repository->findByIdentifier($identifier);
        
        $password = $this->getHashedPassword($authUser);

        $isVerify = $password->verify($request->getPassword());

        if (!$isVerify || !$authUser) {
            return null;
        }

        return $authUser;
    }

    private function getHashedPassword(?AuthenticableUser $authUser): Password
    {
        return $authUser 
            ? $authUser->getPassword()
            : Password::fromHash(self::DUMMY_HASH);
    }
}
