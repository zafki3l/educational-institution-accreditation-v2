<?php

namespace Tests\Modules\Authentication\Application\UseCases;

use App\Modules\Authentication\Application\Requests\LoginRequestInterface;
use App\Modules\Authentication\Application\UseCases\LoginUseCase;
use App\Modules\Authentication\Domain\Entities\AuthenticableUser;
use App\Modules\Authentication\Domain\Repositories\AuthenticableUserRepositoryInterface;
use App\Modules\UserManagement\Domain\ValueObjects\Password;
use App\Modules\UserManagement\Domain\ValueObjects\UserId;
use App\Shared\Contracts\Events\EventDispatcherInterface;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class LoginUseCaseTest extends TestCase
{
    private const VALID_EMAIL = 'phamdinhthai123@gmail.com';
    private const VALID_PASS = 'password123';
    private const WRONG_PASS = 'wrong_password';
    private const NON_EXISTENT_EMAIL = 'nonexistent@example.com';

    private AuthenticableUserRepositoryInterface&MockObject $repositoryMock;
    private EventDispatcherInterface&MockObject $eventDispatcherMock;
    private LoginUseCase $useCase;
    private AuthenticableUser $stubUser;

    protected function setUp(): void
    {
        $this->repositoryMock = $this->createMock(AuthenticableUserRepositoryInterface::class);
        $this->eventDispatcherMock = $this->createMock(EventDispatcherInterface::class);
        
        $this->useCase = new LoginUseCase(
            $this->repositoryMock, 
            $this->eventDispatcherMock
        );

        // Create a stub user for successful scenarios
        $this->stubUser = AuthenticableUser::create(
            UserId::fromString('550e8400-e29b-41d4-a716-446655440000'),
            self::VALID_EMAIL,
            Password::fromPlain(self::VALID_PASS),
            2
        );
    }

    public function testExecuteSuccess(): void
    {
        $request = $this->createMockRequest(self::VALID_EMAIL, self::VALID_PASS);

        $this->repositoryMock->expects($this->once())
            ->method('findByIdentifier')
            ->with(self::VALID_EMAIL)
            ->willReturn($this->stubUser);

        // Verify that success event is dispatched
        $this->eventDispatcherMock->expects($this->once())
            ->method('dispatch');

        $response = $this->useCase->execute($request);

        $this->assertNotNull($response);
        $this->assertSame($this->stubUser->getUserId()->value(), $response->user_id);
        $this->assertSame(self::VALID_EMAIL, $response->identifier);
    }

    #[DataProvider('provideInvalidCredentials')]
    public function testExecuteFailure(string $email, string $password, ?AuthenticableUser $repoReturn): void
    {
        $request = $this->createMockRequest($email, $password);

        $this->repositoryMock->method('findByIdentifier')
            ->willReturn($repoReturn);

        // Verify that failure event is dispatched
        $this->eventDispatcherMock->expects($this->once())
            ->method('dispatch');

        $response = $this->useCase->execute($request);

        $this->assertNull($response);
    }

    public static function provideInvalidCredentials(): array
    {
        // We need to recreate a user for the 'wrong password' case because it's a static provider
        $user = AuthenticableUser::create(
            UserId::fromString('550e8400-e29b-41d4-a716-446655440000'),
            self::VALID_EMAIL,
            Password::fromPlain(self::VALID_PASS),
            2
        );

        return [
            'Email not found' => [self::NON_EXISTENT_EMAIL, self::VALID_PASS, null],
            'Password incorrect' => [self::VALID_EMAIL, self::WRONG_PASS, $user],
        ];
    }

    private function createMockRequest(string $identifier, string $password): LoginRequestInterface&MockObject
    {
        $mock = $this->createMock(LoginRequestInterface::class);
        $mock->method('getIdentifier')->willReturn($identifier);
        $mock->method('getPassword')->willReturn($password);
        return $mock;
    }
}