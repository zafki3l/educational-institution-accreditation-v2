<?php

namespace Tests\Unit\Modules\UserProfile\Application\UseCases;

use App\Modules\UserProfile\Application\Requests\UpdateUserProfileRequestInterface;
use App\Modules\UserProfile\Application\UseCases\UpdateUserProfileUseCase;
use App\Modules\UserProfile\Domain\Entities\UserProfile;
use App\Modules\UserProfile\Domain\Exceptions\EmailExistException;
use App\Modules\UserProfile\Domain\Repositories\UserProfileRepositoryInterface;
use App\Modules\UserProfile\Domain\Services\EmailExistsCheckerInterface;
use App\Shared\Logging\LoggerInterface;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TraitHelper\DebugHelper;

class UpdateUserProfileUseCaseTest extends TestCase
{
    use DebugHelper;

    private UserProfileRepositoryInterface&MockObject $repository;
    private EmailExistsCheckerInterface&MockObject $emailChecker;
    private LoggerInterface&MockObject $logger;
    private UpdateUserProfileUseCase $useCase;

    protected function setUp(): void
    {
        $this->repository = $this->createMock(UserProfileRepositoryInterface::class);
        $this->emailChecker = $this->createMock(EmailExistsCheckerInterface::class);
        $this->logger = $this->createMock(LoggerInterface::class);

        $this->useCase = new UpdateUserProfileUseCase(
            $this->repository,
            $this->emailChecker,
            $this->logger
        );
    }

    /**
     * Run: composer test -- --filter UpdateUserProfileUseCaseTest::it_updates_profile_and_changes_email_successfully
     */
    #[Test]
    public function it_updates_profile_and_changes_email_successfully(): void
    {
        $actorId = 'user-123';
        $newEmail = 'new@example.com';

        $request = $this->createMock(UpdateUserProfileRequestInterface::class);
        $request->method('getFirstName')->willReturn('Nguyen');
        $request->method('getLastName')->willReturn('An');
        $request->method('getEmail')->willReturn($newEmail);

        $this->debug('STEP 1: REQUEST MOCK DATA', [
            'first_name' => $request->getFirstName(),
            'last_name' => $request->getLastName(),
            'email' => $request->getEmail()
        ]);

        $fromDb = UserProfile::fromPersistent($actorId, 'Old', 'Name', 'old@example.com');
        $this->repository->method('getUserProfile')->with($actorId)->willReturn($fromDb);

        $this->emailChecker->method('isExists')->with($newEmail)->willReturn(false);

        $this->repository->expects($this->once())
            ->method('update')
            ->with($this->callback(function (UserProfile $profile) use ($newEmail) {
                $this->debug('ENTITY BEFORE UPDATE REPO', [
                    'id' => $profile->getId(),
                    'first_name' => $profile->getFirstName(),
                    'last_name' => $profile->getLastName(),
                    'email_after_logic' => $profile->getEmail(), 
                ]);
                return $profile->getEmail() === $newEmail;
            }))
            ->willReturnCallback(fn($p) => $p);

        $this->logger->expects($this->once())
            ->method('write')
            ->willReturnCallback(function ($level, $action, $msg, $id, $context) {
                $this->debug('STEP 3: LOG CONTEXT DATA', $context);
            });

        $this->useCase->execute($request, $actorId);
    }

    /**
     * Run: composer test -- --filter UpdateUserProfileUseCaseTest::it_throws_exception_if_new_email_already_exists
     */
    #[Test]
    public function it_throws_exception_if_new_email_already_exists(): void
    {
        $actorId = 'user-123';
        $newEmail = 'exists@example.com';

        $request = $this->createMock(UpdateUserProfileRequestInterface::class);
        $request->method('getEmail')->willReturn($newEmail);
        $request->method('getFirstName')->willReturn('Nguyen');
        $request->method('getLastName')->willReturn('An');

        $fromDb = UserProfile::fromPersistent($actorId, 'Nguyen', 'An', 'old@example.com');
        $this->repository->method('getUserProfile')->willReturn($fromDb);

        $this->emailChecker->method('isExists')
            ->willReturnCallback(function ($email) {
                $this->debug('EXCEPTION TRAP: Checking email existence', [
                    'email_to_check' => $email,
                    'will_throw_next' => 'EmailExistException'
                ]);
                return true;
            });

        $this->expectException(EmailExistException::class);

        $this->debug('Executing UseCase', ['actor' => $actorId]);

        $this->useCase->execute($request, $actorId);
    }

    /**
     * Run: composer test -- --filter UpdateUserProfileUseCaseTest::it_does_not_check_email_if_it_is_same_as_current
     */
    #[Test]
    public function it_does_not_check_email_if_it_is_same_as_current(): void
    {
        $actorId = 'user-123';
        $currentEmail = 'same@example.com';

        $request = $this->createMock(UpdateUserProfileRequestInterface::class);
        $request->method('getEmail')->willReturn($currentEmail);
        $request->method('getFirstName')->willReturn('Nguyen');
        $request->method('getLastName')->willReturn('An');

        $fromDb = UserProfile::fromPersistent($actorId, 'Nguyen', 'An', $currentEmail);
        $this->repository->method('getUserProfile')->willReturn($fromDb);

        $this->debug('DEBUG: COMPARING EMAILS', [
            'request_email' => $currentEmail,
            'db_email' => $fromDb->getEmail(),
            'should_trigger_checker' => 'NO'
        ]);

        $this->emailChecker->expects($this->never())->method('isExists');
        
        $this->repository->expects($this->once())
            ->method('update')
            ->willReturnCallback(function($profile) {
                $this->debug('REPO UPDATE CALLED', ['email' => $profile->getEmail()]);
                return $profile;
            });

        $this->useCase->execute($request, $actorId);
    }
}