<?php

use App\Modules\Authentication\Application\UseCases\LogoutUseCase;
use App\Shared\SessionManager\AuthSession;
use PHPUnit\Framework\TestCase;

final class LogoutUseCaseTest extends TestCase
{
    /**
     * Run: composer test -- --filter LogoutUseCaseTest::testExecuteCallsClearSession
     * 
     * @return void
     */
    public function testExecuteCallsClearSession(): void
    {
        $sessionMock = $this->createMock(AuthSession::class);

        $sessionMock->expects($this->once())
            ->method('clear');

        $useCase = new LogoutUseCase($sessionMock);
        
        $useCase->execute();
    }
}