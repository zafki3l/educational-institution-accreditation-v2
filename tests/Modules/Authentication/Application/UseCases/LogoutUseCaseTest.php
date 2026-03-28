<?php

namespace Tests\Modules\Authentication\Application\UseCases;

use App\Modules\Authentication\Application\UseCases\LogoutUseCase;
use App\Shared\Contracts\Events\EventDispatcherInterface;
use App\Shared\SessionManager\AuthSession;
use App\Shared\SessionManager\SessionAuthUser;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class LogoutUseCaseTest extends TestCase
{
    private AuthSession&MockObject $sessionMock;
    private EventDispatcherInterface&MockObject $eventDispatcherMock;
    private LogoutUseCase $useCase;

    protected function setUp(): void
    {
        $this->sessionMock = $this->createMock(AuthSession::class);
        $this->eventDispatcherMock = $this->createMock(EventDispatcherInterface::class);
        
        $this->useCase = new LogoutUseCase(
            $this->sessionMock, 
            $this->eventDispatcherMock
        );
    }

    public function testExecuteLogsOutUserWhenSessionIsActive(): void
    {
        // Simulate user in session
        $stubUser = new SessionAuthUser(
            user_id: 'user-123',
            identifier: 'test@example.com',
            role_id: 2
        );
    
        $this->sessionMock->method('authUser')->willReturn($stubUser);

        // Expecting event excuted and session cleared
        $this->eventDispatcherMock->expects($this->once())
            ->method('dispatch');
            
        $this->sessionMock->expects($this->once())
            ->method('clear');

        $this->useCase->execute();
    }

    public function testExecuteDoesNothingWhenNoUserInSession(): void
    {
        // Simulate no user in session
        $this->sessionMock->method('authUser')->willReturn(null);

        // expecting no event excuted and no session cleared
        $this->eventDispatcherMock->expects($this->never())
            ->method('dispatch');
            
        $this->sessionMock->expects($this->never())
            ->method('clear');

        $this->useCase->execute();
    }
}