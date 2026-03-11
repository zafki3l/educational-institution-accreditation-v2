<?php

namespace Tests\Unit\Modules\DepartmentManagement\Application\UseCases;

use App\Modules\DepartmentManagement\Application\Requests\UpdateDepartmentRequestInterface;
use App\Modules\DepartmentManagement\Application\UseCases\UpdateDepartmentUseCase;
use App\Modules\DepartmentManagement\Domain\Entities\Department; // Giả sử đây là Entity của bạn
use App\Modules\DepartmentManagement\Domain\Exception\DepartmentNotFoundException;
use App\Modules\DepartmentManagement\Domain\Repositories\DepartmentRepositoryInterface;
use App\Shared\Logging\LoggerInterface;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TraitHelper\DebugHelper;

final class UpdateDepartmentUseCaseTest extends TestCase
{
    use DebugHelper;

    private DepartmentRepositoryInterface&MockObject $repository;
    private LoggerInterface&MockObject $logger;
    private UpdateDepartmentUseCase $useCase;

    protected function setUp(): void
    {
        $this->repository = $this->createMock(DepartmentRepositoryInterface::class);
        $this->logger = $this->createMock(LoggerInterface::class);

        $this->useCase = new UpdateDepartmentUseCase(
            $this->repository,
            $this->logger
        );
    }

    /**
     * Test cập nhật phòng ban thành công
     */
    public function testExecuteSuccessfully(): void
    {
        $departmentId = 'DEPT-001';
        $actorId = 'admin-1';
        $newName = 'Phòng Đào Tạo Mới';

        $this->debug('START', 'Bắt đầu test cập nhật phòng ban');

        // 1. Arrange - Tạo Request Mock
        $request = $this->createMock(UpdateDepartmentRequestInterface::class);
        $request->method('getName')->willReturn($newName);

        // 2. Arrange - Sử dụng Entity THẬT thay vì Mock để tránh lỗi TypeError/Null
        // Giả sử constructor Department nhận (id, name)
        $department = Department::create($departmentId, 'Tên Cũ'); 

        $this->repository->method('findOrFail')
            ->with($departmentId)
            ->willReturn($department);

        // 3. Assert - Kiểm tra Repo có gọi hàm update với Entity đã thay đổi tên không
        $this->repository->expects($this->once())
            ->method('update')
            ->with($this->callback(function (Department $dept) use ($newName) {
                $this->debug('CHECK_ENTITY', ['name' => $dept->getName()]);
                return $dept->getName() === $newName;
            }));

        // 4. Assert - Kiểm tra Logger
        $this->logger->expects($this->once())
            ->method('write')
            ->with('info', 'update', $this->anything(), $actorId);

        // 5. Act
        $this->useCase->execute($departmentId, $request, $actorId);

        $this->debug('END', 'Cập nhật phòng ban thành công');
    }

    /**
     * Test trường hợp không tìm thấy phòng ban
     */
    public function testExecuteThrowsExceptionWhenNotFound(): void
    {
        $this->debug('START', 'Test lỗi không tìm thấy phòng ban');

        $departmentId = 'UNKNOWN';
        $request = $this->createMock(UpdateDepartmentRequestInterface::class);

        // Giả lập Repository trả về null
        $this->repository->method('findOrFail')->willReturn(null);

        $this->expectException(DepartmentNotFoundException::class);

        try {
            $this->useCase->execute($departmentId, $request, 'actor-1');
        } catch (DepartmentNotFoundException $e) {
            $this->debug('CATCHED', 'Bắt được lỗi DepartmentNotFoundException đúng kỳ vọng');
            throw $e;
        }
    }
}