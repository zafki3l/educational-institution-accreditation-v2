<?php

namespace Tests\Unit\Modules\FileUpload\Application;

use App\Modules\FileUpload\Application\UploadFileUseCase;
use App\Modules\FileUpload\Domain\Exceptions\SizeTooBigException;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TraitHelper\DebugHelper;

class UploadFileUseCaseTest extends TestCase
{
    use DebugHelper;

    private UploadFileUseCase $useCase;

    protected function setUp(): void
    {
        $this->useCase = new UploadFileUseCase();
    }

    /**
     * Run: composer test -- --filter UploadFileUseCaseTest::it_uploads_file_successfully_with_custom_name
     */
    #[Test]
    public function it_uploads_file_successfully_with_custom_name(): void
    {
        $fileData = [
            'name' => 'document.pdf',
            'type' => 'application/pdf',
            'tmp_name' => '/tmp/phpYzdS28',
            'error' => 0,
            'size' => 1024 * 500,
        ];

        $this->debug('STEP 1: INPUT FILE DATA', $fileData);

        $customName = 'User_Profile_Photo';
        $result = $this->useCase->execute($fileData, $customName);

        $this->debug('STEP 2: GENERATED STORED NAME', [
            'returned_name' => $result,
            'contains_custom_name' => str_contains($result, 'User_Profile_Photo'),
            'has_extension' => str_ends_with($result, '.pdf')
        ]);

        $this->assertStringContainsString('User_Profile_Photo', $result);
        $this->assertStringEndsWith('.pdf', $result);
    }

    /**
     * Run: composer test -- --filter UploadFileUseCaseTest::it_throws_exception_when_file_is_too_large
     */
    #[Test]
    public function it_throws_exception_when_file_is_too_large(): void
    {
        $fileData = [
            'name' => 'huge_movie.mp4',
            'size' => 99_000_000,
            'tmp_name' => '/tmp/huge',
        ];

        $this->debug('STEP 1: TESTING OVERSIZE FILE', ['size' => $fileData['size']]);

        $this->expectException(SizeTooBigException::class);

        $this->useCase->execute($fileData);
    }
}