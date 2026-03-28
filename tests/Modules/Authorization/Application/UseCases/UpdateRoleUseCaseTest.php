<?php

namespace Tests\Modules\Authorization\Application\UseCases;

use App\Modules\Authorization\Application\Requests\UpdateRoleRequestInterface;
use App\Modules\Authorization\Application\UseCases\UpdateRoleUseCase;
use App\Modules\Authorization\Domain\Entities\Role;
use App\Modules\Authorization\Domain\Exception\EmptyRoleNameException;
use App\Modules\Authorization\Domain\Repositories\RoleRepositoryInterface;
use App\Shared\Contracts\Events\EventDispatcherInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class UpdateRoleUseCaseTest extends TestCase
{
    private UpdateRoleUseCase $useCase;
    private RoleRepositoryInterface&MockObject $repositoryMock;
    private EventDispatcherInterface&MockObject $eventDispatcherMock;

    private const ROLE_ID = 1;
    private const OLD_NAME = 'Old Role';
    private const NEW_NAME = 'Updated Role';
    private const ACTOR_ID = 'admin-001';

    protected function setUp(): void
    {
        $this->repositoryMock = $this->createMock(RoleRepositoryInterface::class);
        $this->eventDispatcherMock = $this->createMock(EventDispatcherInterface::class);

        $this->useCase = new UpdateRoleUseCase(
            $this->repositoryMock,
            $this->eventDispatcherMock
        );
    }

    public function testExecuteSuccess(): void
    {
        $role = Role::create(self::OLD_NAME);
        $role->assignId(self::ROLE_ID);

        $request = $this->createMock(UpdateRoleRequestInterface::class);
        $request->method('getId')->willReturn(self::ROLE_ID);
        $request->method('getName')->willReturn(self::NEW_NAME);

        $this->repositoryMock->expects($this->once())
            ->method('findOrFail')
            ->with(self::ROLE_ID)
            ->willReturn($role);

        $this->repositoryMock->expects($this->once())
            ->method('update')
            ->with($this->callback(fn(Role $r) => $r->getName() === self::NEW_NAME));

        $this->eventDispatcherMock->expects($this->once())
            ->method('dispatch');

        $this->useCase->execute($request, self::ACTOR_ID);
        
        $this->assertSame(self::NEW_NAME, $role->getName());
    }

    public function testExecuteThrowsExceptionWhenRoleNotFound(): void
    {
        $request = $this->createMock(UpdateRoleRequestInterface::class);
        $request->method('getId')->willReturn(999);

        $this->repositoryMock->method('findOrFail')
            ->willThrowException(new \Exception("Role not found"));

        $this->repositoryMock->expects($this->never())->method('update');
        $this->eventDispatcherMock->expects($this->never())->method('dispatch');

        $this->expectException(\Exception::class);
        
        $this->useCase->execute($request, self::ACTOR_ID);
    }

    public function testExecuteThrowsExceptionWhenNewNameIsEmpty(): void
    {
        $role = Role::create(self::OLD_NAME);
        $role->assignId(self::ROLE_ID);

        $request = $this->createMock(UpdateRoleRequestInterface::class);
        $request->method('getId')->willReturn(self::ROLE_ID);
        $request->method('getName')->willReturn('');

        $this->repositoryMock->method('findOrFail')->willReturn($role);

        $this->expectException(EmptyRoleNameException::class);

        $this->useCase->execute($request, self::ACTOR_ID);
    }
}