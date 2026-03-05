<?php

namespace Tests\Unit\Modules\UserManagement\Application\UseCases;

use App\Modules\UserManagement\Application\Requests\UpdateUserRequestInterface;
use App\Modules\UserManagement\Application\UseCases\UpdateUserUseCase;
use App\Modules\UserManagement\Domain\Entities\User;
use App\Modules\UserManagement\Domain\Repositories\UserRepositoryInterface;
use App\Shared\Logging\LoggerInterface;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TraitHelper\DebugHelper;

class UpdateUserUseCaseTest extends TestCase
{
    use DebugHelper;

    private UserRepositoryInterface&MockObject $repository;
    private LoggerInterface&MockObject $logger;
    private UpdateUserUseCase $useCase;

    protected function setUp(): void
    {
        $this->repository = $this->createMock(UserRepositoryInterface::class);
        $this->logger = $this->createMock(LoggerInterface::class);
        $this->useCase = new UpdateUserUseCase($this->repository, $this->logger);
    }

    /**
     * Run: composer test -- --filter UpdateUserUseCaseTest::it_updates_user_successfully
     */
    #[Test]
    public function it_updates_user_successfully(): void
    {
        $userId = 'user-uuid-123';
        $actorId = 'actor-uuid-456';

        $request = $this->createMock(UpdateUserRequestInterface::class);
        $request->method('getId')->willReturn($userId);
        $request->method('getFirstName')->willReturn('Tran');
        $request->method('getLastName')->willReturn('B');
        $request->method('getEmail')->willReturn('tranb@example.com');
        $request->method('getRoleId')->willReturn(2);
        $request->method('getDepartmentId')->willReturn('dept-002');

        $user = $this->createMock(User::class);
        
        $this->repository->expects($this->once())
            ->method('findOrFail')
            ->with($userId)
            ->willReturn($user);

        $user->expects($this->once())
            ->method('update')
            ->with(
                'Tran',
                'B',
                'tranb@example.com',
                2,
                'dept-002'
            );

        $this->repository->expects($this->once())
            ->method('save')
            ->with($user);

        $this->logger->expects($this->once())->method('write');

        $this->useCase->execute($request, $actorId);
    }

    /**
     * Run: composer test -- --filter UpdateUserUseCaseTest::it_converts_empty_strings_to_null_during_update
     */
    #[Test]
    public function it_converts_empty_strings_to_null_during_update(): void
    {
        $request = $this->createMock(UpdateUserRequestInterface::class);
        $request->method('getEmail')->willReturn('');
        $request->method('getDepartmentId')->willReturn('');

        $user = $this->createMock(User::class);
        $this->repository->method('findOrFail')->willReturn($user);

        $user->expects($this->once())
            ->method('update')
            ->with(
                $this->anything(),
                $this->anything(),
                $this->isNull(),
                $this->anything(),
                $this->isNull()
            );

        $this->useCase->execute($request, 'actor-123');
    }
}