<?php

namespace Tests\Modules\Authorization\Application\UseCases;

use App\Modules\Authorization\Application\Requests\CreateRoleRequestInterface;
use App\Modules\Authorization\Application\UseCases\CreateRoleUseCase;
use App\Modules\Authorization\Domain\Entities\Role;
use App\Modules\Authorization\Domain\Repositories\RoleRepositoryInterface;
use App\Shared\Contracts\Events\EventDispatcherInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class CreateRoleUseCaseTest extends TestCase
{
    private CreateRoleUseCase $useCase;
    private RoleRepositoryInterface&MockObject $repositoryMock;
    private EventDispatcherInterface&MockObject $eventDispatcherMock;
    
    private const ROLE_NAME = 'Admin';
    private const ACTOR_ID = 'user-123';

    protected function setUp(): void
    {
        $this->repositoryMock = $this->createMock(RoleRepositoryInterface::class);
        $this->eventDispatcherMock = $this->createMock(EventDispatcherInterface::class);

        $this->useCase = new CreateRoleUseCase(
            $this->repositoryMock, 
            $this->eventDispatcherMock
        );
    }

    public function testExecuteSuccess(): void
    {
        $request = $this->createMock(CreateRoleRequestInterface::class);
        $request->method('getName')->willReturn(self::ROLE_NAME);

        $this->repositoryMock->expects($this->once())
            ->method('create')
            ->with($this->callback(function (Role $role) {
                return $role->getName() === self::ROLE_NAME;
            }));

        $this->eventDispatcherMock->expects($this->once())
            ->method('dispatch');

        $this->useCase->execute($request, self::ACTOR_ID);
    }

    public function testExecuteFailsWhenRepositoryThrowsException(): void
    {
        $request = $this->createMock(CreateRoleRequestInterface::class);
        $request->method('getName')->willReturn(self::ROLE_NAME);

        $this->repositoryMock->method('create')
            ->willThrowException(new \Exception('Database Error'));

        $this->eventDispatcherMock->expects($this->never())->method('dispatch');

        $this->expectException(\Exception::class);
        
        $this->useCase->execute($request, self::ACTOR_ID);
    }
}