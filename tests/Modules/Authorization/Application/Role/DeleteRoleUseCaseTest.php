<?php

namespace Tests\Modules\Authorization\Application\Role;

use App\Modules\Authorization\Application\Role\UseCases\DeleteRoleUseCase;
use App\Modules\Authorization\Domain\Entities\Role;
use App\Modules\Authorization\Domain\Repositories\RoleRepositoryInterface;
use App\Shared\Logging\LoggerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Tests\TraitHelper\DebugHelper;

final class DeleteRoleUseCaseTest extends TestCase
{
    use DebugHelper;

    private RoleRepositoryInterface&MockObject $repository;
    private LoggerInterface&MockObject $logger;
    private DeleteRoleUseCase $useCase;

    protected function setUp(): void
    {
        $this->repository = $this->createMock(RoleRepositoryInterface::class);
        $this->logger = $this->createMock(LoggerInterface::class);
        $this->useCase = new DeleteRoleUseCase($this->repository, $this->logger);
    }

    /**
     * Run: composer test -- --filter DeleteRoleUseCaseTest::testDeleteRoleSuccess
     * 
     * @return void
     */
    public function testDeleteRoleSuccess(): void
    {
        $roleId = 3;
        $actorId = 'admin_007';

        $role = Role::create('Editor');
        $role->assignId($roleId);

        $this->repository->expects($this->once())
            ->method('findOrFail')
            ->with($roleId)
            ->willReturn($role);

        $this->repository->expects($this->once())
            ->method('delete')
            ->with($role);

        $this->logger->expects($this->once())
            ->method('write')
            ->willReturnCallback(function ($level, $action, $message, $actor, $context) use ($roleId, $actorId) {
                $this->debug('Delete Role Log Details', [
                    'msg' => $message,
                    'context_id' => $context['id']
                ]);
                $this->assertStringContainsString((string)$roleId, $message);
                $this->assertEquals($actorId, $actor);
            });

        $this->useCase->execute($roleId, $actorId);
    }

    /**
     * Run: composer test -- --filter DeleteRoleUseCaseTest::testDeleteRoleFailsWhenNotFound
     * 
     * @return void
     */
    public function testDeleteRoleFailsWhenNotFound(): void
    {
        $roleId = 999;
        
        $this->repository->method('findOrFail')
            ->willThrowException(new \Exception("Role not found"));

        $this->repository->expects($this->never())->method('delete');
        $this->logger->expects($this->never())->method('write');

        $this->expectException(\Exception::class);
        
        $this->debug('Scenario', 'Check if the Use Case stops when the Role does not exist...');
        
        $this->useCase->execute($roleId, 'actor_1');
    }
}