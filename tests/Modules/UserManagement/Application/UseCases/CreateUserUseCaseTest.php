<?php

namespace Tests\Unit\Modules\UserManagement\Application\UseCases;

use App\Modules\UserManagement\Application\Requests\CreateUserRequestInterface;
use App\Modules\UserManagement\Application\UseCases\CreateUserUseCase;
use App\Modules\UserManagement\Domain\Entities\User;
use App\Modules\UserManagement\Domain\Exception\EmailExistException;
use App\Modules\UserManagement\Domain\Repositories\UserRepositoryInterface;
use App\Modules\UserManagement\Domain\Services\EmailExistsCheckerInterface;
use App\Modules\UserManagement\Domain\ValueObjects\Email;
use App\Shared\Logging\LoggerInterface;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TraitHelper\DebugHelper;

class CreateUserUseCaseTest extends TestCase
{
    use DebugHelper;

    private UserRepositoryInterface&MockObject $userRepository;
    private EmailExistsCheckerInterface&MockObject $emailChecker;
    private LoggerInterface&MockObject $logger;
    private CreateUserUseCase $useCase;

    protected function setUp(): void
    {
        $this->userRepository = $this->createMock(UserRepositoryInterface::class);
        $this->emailChecker = $this->createMock(EmailExistsCheckerInterface::class);
        $this->logger = $this->createMock(LoggerInterface::class);

        $this->useCase = new CreateUserUseCase(
            $this->userRepository,
            $this->emailChecker,
            $this->logger
        );
    }

    /**
     * Run: composer test -- --filter CreateUserUseCaseTest::it_creates_user_successfully
     */
    #[Test]
    public function it_creates_user_successfully(): void
    {
        $request = $this->createMock(CreateUserRequestInterface::class);
        $request->method('getEmail')->willReturn('test@example.com');
        $request->method('getFirstName')->willReturn('An');
        $request->method('getLastName')->willReturn('Nguyen');
        $request->method('getPassword')->willReturn('Password123');
        $request->method('getRoleId')->willReturn(1);

        // assuming that the email does not exist in the database
        $this->emailChecker->method('isExists')->willReturn(false);

        $this->userRepository->expects($this->once())
            ->method('create')
            ->with($this->isInstanceOf(User::class))
            ->willReturnCallback(function (User $user) {
                $this->debug('USER DATA BEFORE SAVING', [
                    'id' => $user->getUserId()->value(),
                    'auth_id' => $user->getAuthId()->value(),
                    'full_name' => $user->getFullName(),
                    'email' => $user->getEmail()?->value(),
                    'role_id' => $user->getRoleId(),
                    'department_id' => $user->getDepartmentId()
                ]);
                return $user;
            });

        $this->logger->expects($this->once())
            ->method('write')
            ->willReturnCallback(function ($level, $action, $message, $actorId, $context) {
                $this->debug('DỮ LIỆU LOG HỆ THỐNG', [
                    'message'  => $message,
                    'actor_id' => $actorId,
                    'context'  => $context
                ]);
            });

        $this->useCase->execute($request, 'actor-uuid');
    }

    /**
     * Run: composer test -- --filter CreateUserUseCaseTest::it_throws_exception_when_email_already_exists
     */
    #[Test]
    public function it_throws_exception_when_email_already_exists(): void
    {
        $request = $this->createMock(CreateUserRequestInterface::class);
        $request->method('getEmail')->willReturn('existing@example.com');

        $this->emailChecker->method('isExists')
            ->willReturnCallback(function (Email $email) {
                $this->debug('CHECKING EMAIL EXISTENCE', [
                    'email_value' => $email->value(),
                    'status' => 'Mocking as EXISTS'
                ]);
                return true;
            });

        $this->expectException(EmailExistException::class);
        
        $this->userRepository->expects($this->never())->method('create');

        $this->useCase->execute($request, 'actor-uuid');
    }
}