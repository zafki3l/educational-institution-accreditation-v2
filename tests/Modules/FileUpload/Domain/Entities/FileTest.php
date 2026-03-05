<?php

namespace Tests\Unit\Modules\FileUpload\Domain\Entities;

use App\Modules\FileUpload\Domain\Entities\File;
use App\Modules\FileUpload\Domain\Exceptions\FileExtensionInvalidException;
use App\Modules\FileUpload\Domain\Exceptions\SizeTooBigException;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\DataProvider;

final class FileTest extends TestCase
{
    /**
     * Run: composer test -- --filter FileTest::it_can_be_created_with_valid_data
     */
    #[Test]
    public function it_can_be_created_with_valid_data(): void
    {
        $originalName = 'image.png';
        $storedName = 'uuid-stored-name.png';
        $path = 'uploads/2024/';
        $extension = 'png';
        $size = 5000; // 5KB

        $file = File::create($originalName, $storedName, $path, $extension, $size);

        $this->assertInstanceOf(File::class, $file);
        $this->assertEquals($originalName, $file->getOriginalName());
        $this->assertEquals($extension, $file->getExtension());
        $this->assertEquals($size, $file->getSize());
    }

    /**
     * Run: composer test -- --filter FileTest::it_throws_exception_when_file_size_is_too_big
     */
    #[Test]
    public function it_throws_exception_when_file_size_is_too_big(): void
    {
        $this->expectException(SizeTooBigException::class);

        // Giới hạn là 20,000,000 bytes. Truyền vào 20,000,001 bytes
        File::create('big-file.pdf', 'stored.pdf', 'path/', 'pdf', 20_000_001);
    }

    /**
     * Run: composer test -- --filter FileTest::it_throws_exception_when_extension_is_invalid
     */
    #[Test]
    #[DataProvider('invalidExtensionProvider')]
    public function it_throws_exception_when_extension_is_invalid(string $invalidExt): void
    {
        $this->expectException(FileExtensionInvalidException::class);

        File::create('doc.exe', 'stored.exe', 'path/', $invalidExt, 1000);
    }

    public static function invalidExtensionProvider(): array
    {
        return [
            ['exe'],
            ['php'],
            ['zip'],
            ['txt'],
            ['PNG'], // Vì in_array mặc định phân biệt hoa thường, nếu bạn muốn cho phép hãy dùng strtolower
        ];
    }

    /**
     * Run: composer test -- --filter FileTest::it_allows_maximum_boundary_size
     */
    #[Test]
    public function it_allows_maximum_boundary_size(): void
    {
        $file = File::create('edge.jpg', 'edge.jpg', 'path/', 'jpg', 20_000_000);
        
        $this->assertEquals(20000000, $file->getSize());
    }
}