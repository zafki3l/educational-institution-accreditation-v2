<?php

namespace Tests\Modules\Authorization\Application\Role;

use App\Modules\Authorization\Application\Role\Requests\CreateRoleRequestInterface;
use App\Modules\Authorization\Application\Role\UseCases\CreateRoleUseCase;
use App\Modules\Authorization\Domain\Entities\Role;
use App\Modules\Authorization\Domain\Exception\EmptyRoleNameException;
use App\Modules\Authorization\Domain\Repositories\RoleRepositoryInterface;
use App\Shared\Logging\LoggerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Tests\TraitHelper\DebugHelper;

final class CreateRoleUseCaseTest extends TestCase
{
    use DebugHelper;

    private CreateRoleUseCase $createRoleUseCase;
    private RoleRepositoryInterface&MockObject $repository;
    private LoggerInterface&MockObject $logger;
    private Role $role;
    private int $expectedRoleId;
    private string $expectedName;
    private string $actor_id;

    public function setUp(): void
    {
        $this->expectedRoleId = 3;
        $this->expectedName = 'Admin';
        $this->actor_id = 'a123123213';

        $this->role = Role::create($this->expectedName);
        $this->role->assignId($this->expectedRoleId);

        $this->repository = $this->createMock(RoleRepositoryInterface::class);
        $this->logger = $this->createMock(LoggerInterface::class);

        $this->createRoleUseCase = new CreateRoleUseCase($this->repository, $this->logger);
    }

    private function createMockRequest(string $name): CreateRoleRequestInterface&MockObject
    {
        $request = $this->createMock(CreateRoleRequestInterface::class);
        $request->method('getName')->willReturn($name);
        
        return $request;
    }

    /**
     * Run: composer test -- --filter CreateRoleUseCaseTest::testExecuteSuccess
     * 
     * @return void
     */
    public function testExecuteSuccess()
    {
        $request = $this->createMockRequest($this->expectedName);

        $this->repository
            ->expects($this->once())
            ->method('create')
            ->with($this->callback(function (Role $role) {
                $this->debug('Entity inside UseCase', [
                    'class' => get_class($role),
                    'name'  => $role->getName(),
                    'id'    => $role->getId()
                ]);
                return $role->getName() === $this->expectedName && is_null($role->getId());
            }));

        $this->createRoleUseCase->execute($request, $this->actor_id);
    }

    /**
     * Run: composer test -- --filter CreateRoleUseCaseTest::testExecuteThrowsExceptionWhenNameIsEmpty
     * 
     * @return void
     */
    public function testExecuteThrowsExceptionWhenNameIsEmpty(): void
    {
        $request = $this->createMockRequest(''); 
        
        $this->repository->expects($this->never())->method('create');
        
        $this->expectException(EmptyRoleNameException::class);

        $this->debug('Scenario: Empty Name', 'Simulating an empty name, expecting Exception and Repository not to be called.');
        
        $this->createRoleUseCase->execute($request, $this->actor_id);
    }

    /**
     * Run: composer test -- --filter CreateRoleUseCaseTest::testExecuteDoesNotLogWhenRepositoryFails
     * 
     * @return void
     */
    public function testExecuteDoesNotLogWhenRepositoryFails(): void
    {
        $request = $this->createMockRequest('Admin');
        $errorMessage = 'Database Connection Error';

        $this->repository->method('create')
            ->willThrowException(new \Exception('Database Connection Error'));

        $this->logger->expects($this->never())->method('write');

        $this->expectException(\Exception::class);

        $this->debug('Scenario: Repo Fail', [
            'msg' => 'Simulate a DB error, check if the Logger is called by mistake...',
            'repo_error' => $errorMessage
        ]);

        $this->createRoleUseCase->execute($request, $this->actor_id);
    }

    /**
     * Run: composer test -- --filter CreateRoleUseCaseTest::testExecuteLogsCorrectMessage
     * 
     * @return void
     */
    public function testExecuteLogsCorrectMessage(): void
    {
        $request = $this->createMockRequest('Manager');

        $this->logger->expects($this->once())
            ->method('write')
            ->willReturnCallback(function ($level, $action, $message, $actorId, $context) {
                $this->debug('Logger Debug Output', [
                    'level'   => $level,
                    'action'  => $action,
                    'message' => $message,
                    'actor'   => $actorId,
                    'payload' => $context
                ]);

                $this->assertEquals('info', $level);
                $this->assertEquals($this->actor_id, $actorId);
                $this->assertStringContainsString($this->actor_id, $message);
            });

        $this->createRoleUseCase->execute($request, $this->actor_id);
    }
}