<?php

namespace Tests\Unit\Modules\UserManagement\Application\UseCases;

use App\Modules\UserManagement\Application\UseCases\DeleteUserUseCase;
use App\Modules\UserManagement\Domain\Entities\User;
use App\Modules\UserManagement\Domain\Repositories\UserRepositoryInterface;
use App\Modules\UserManagement\Domain\ValueObjects\UserId;
use App\Shared\Logging\LoggerInterface;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TraitHelper\DebugHelper;

class DeleteUserUseCaseTest extends TestCase
{
    use DebugHelper;

    private UserRepositoryInterface&MockObject $repository;
    private LoggerInterface&MockObject $logger;
    private DeleteUserUseCase $useCase;

    protected function setUp(): void
    {
        $this->repository = $this->createMock(UserRepositoryInterface::class);
        $this->logger = $this->createMock(LoggerInterface::class);
        $this->useCase = new DeleteUserUseCase($this->repository, $this->logger);
    }

    /**
     * Run: composer test -- --filter DeleteUserUseCaseTest::it_deletes_user_successfully
     */
    #[Test]
    public function it_deletes_user_successfully(): void
    {
        $userIdStr = 'f47ac10b-58cc-4372-a567-0e02b2c3d479';
        $actorId = 'actor-123';

        $user = $this->createMock(User::class);
        $user->method('getUserId')->willReturn(UserId::fromString($userIdStr));
        $user->method('getFirstName')->willReturn('Van');
        $user->method('getLastName')->willReturn('A');

        $this->repository->expects($this->once())
            ->method('findOrFail')
            ->with($userIdStr)
            ->willReturn($user);

        $this->repository->expects($this->once())
            ->method('delete')
            ->with($userIdStr);

        $this->logger->expects($this->once())
            ->method('write')
            ->willReturnCallback(function ($level, $action, $message) use ($userIdStr) {
                $this->debug('DELETE LOG CHECK', [
                    'message' => $message,
                    'expected_id' => $userIdStr
                ]);
            });

        $this->useCase->execute($userIdStr, $actorId);
    }

    /**
     * Run: composer test -- --filter DeleteUserUseCaseTest::it_fails_when_user_not_found
     */
    #[Test]
    public function it_fails_when_user_not_found(): void
    {
        $invalidId = 'non-existent-id';
        
        $this->repository->method('findOrFail')
            ->willThrowException(new \Exception("User not found"));

        $this->expectException(\Exception::class);

        $this->repository->expects($this->never())->method('delete');
        $this->logger->expects($this->never())->method('write');

        $this->useCase->execute($invalidId, 'actor-123');
    }
}