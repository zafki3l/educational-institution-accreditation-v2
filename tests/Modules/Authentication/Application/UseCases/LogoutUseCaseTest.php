<?php

use App\Modules\Authentication\Application\UseCases\LogoutUseCase;
use App\Shared\SessionManager\AuthSession;
use PHPUnit\Framework\TestCase;

class LogoutUseCaseTest extends TestCase
{
    public function testExecuteCallsClearSession(): void
    {
        $sessionMock = $this->createMock(AuthSession::class);

        $sessionMock->expects($this->once())
            ->method('clear');

        $useCase = new LogoutUseCase($sessionMock);
        
        $useCase->execute();
    }
}