<?php

namespace Tests\Unit\Modules\UserProfile\Application\UseCases;

use App\Modules\UserProfile\Application\Requests\ChangePasswordRequestInterface;
use App\Modules\UserProfile\Application\UseCases\ChangePasswordUseCase;
use App\Modules\UserProfile\Domain\Entities\UserProfile;
use App\Modules\UserProfile\Domain\Exceptions\NewPasswordNotMatchingException;
use App\Modules\UserProfile\Domain\Repositories\UserProfileRepositoryInterface;
use App\Modules\UserProfile\Domain\Services\VerifyCurrentPasswordInterface;
use App\Shared\Logging\LoggerInterface;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TraitHelper\DebugHelper;

final class ChangePasswordUseCaseTest extends TestCase
{
    use DebugHelper;

    private UserProfileRepositoryInterface&MockObject $repository;
    private LoggerInterface&MockObject $logger;
    private VerifyCurrentPasswordInterface&MockObject $verifyCurrentPassword;
    private ChangePasswordUseCase $useCase;

    protected function setUp(): void
    {
        $this->repository = $this->createMock(UserProfileRepositoryInterface::class);
        $this->logger = $this->createMock(LoggerInterface::class);
        $this->verifyCurrentPassword = $this->createMock(VerifyCurrentPasswordInterface::class);

        $this->useCase = new ChangePasswordUseCase(
            $this->repository,
            $this->logger,
            $this->verifyCurrentPassword
        );
    }

    /**
     * Run: composer test -- --filter ChangePasswordUseCaseTest::testExecuteSuccessfully
     * 
     * @return void
     */
    public function testExecuteSuccessfully(): void
    {
        $actorId = 'user-123';
        $newPass = 'NewPassword123@';
        $this->debug('START', 'Bắt đầu test đổi mật khẩu thành công');

        $request = $this->createMock(ChangePasswordRequestInterface::class);
        $request->method('getCurrentPassword')->willReturn('OldPassword123@');
        $request->method('getNewPassword')->willReturn($newPass);
        $request->method('getNewPasswordConfirmation')->willReturn($newPass);

        $this->verifyCurrentPassword->expects($this->once())
            ->method('verify')
            ->with('OldPassword123@', $actorId);

        $userProfile = $this->createMock(UserProfile::class);
        $userProfile->method('getId')->willReturn($actorId);
        $userProfile->method('getFirstName')->willReturn('Huy');
        $userProfile->method('getLastName')->willReturn('Nguyen');
        
        $userProfile->method('getPassword')->willReturn('hashed_password_123');

        $this->repository->method('getUserProfile')->with($actorId)->willReturn($userProfile);

        $this->repository->expects($this->once())
            ->method('changePassword')
            ->willReturnCallback(function($hashedPassword, $id) use ($userProfile) {
                $this->debug('REPO_ACTION', ['id' => $id]);
                return $userProfile; 
            });

        $this->useCase->execute($request, $actorId);

        $this->debug('END', 'Đổi mật khẩu thành công và đã ghi log');
    }

    /**
     * Run: composer test -- --filter ChangePasswordUseCaseTest::testExecuteSuccessfully
     * 
     * @return void
     */
    public function testExecuteThrowsExceptionWhenNewPasswordNotMatching(): void
    {
        $this->debug('START', 'Test lỗi mật khẩu xác nhận không khớp');

        $request = $this->createMock(ChangePasswordRequestInterface::class);
        $request->method('getNewPassword')->willReturn('password123');
        $request->method('getNewPasswordConfirmation')->willReturn('password456');

        $this->expectException(NewPasswordNotMatchingException::class);

        try {
            $this->useCase->execute($request, 'user-123');
        } catch (NewPasswordNotMatchingException $e) {
            $this->debug('CATCHED', 'Bắt được lỗi khớp mật khẩu thành công');
            throw $e;
        }
    }

    /**
     * Run: composer test -- --filter ChangePasswordUseCaseTest::testExecuteSuccessfully
     * 
     * @return void
     */
    public function testExecuteThrowsExceptionWhenCurrentPasswordInvalid(): void
    {
        $this->debug('START', 'Test lỗi mật khẩu hiện tại không đúng');

        $request = $this->createMock(ChangePasswordRequestInterface::class);
        
        $this->verifyCurrentPassword->method('verify')
            ->willThrowException(new \Exception('Mật khẩu hiện tại không chính xác'));

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Mật khẩu hiện tại không chính xác');

        $this->useCase->execute($request, 'user-123');
    }
}