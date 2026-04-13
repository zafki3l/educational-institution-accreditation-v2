<?php

namespace App\Modules\FileUpload\Domain\Entities;

use App\Modules\FileUpload\Domain\Exceptions\FileExtensionInvalidException;
use App\Modules\FileUpload\Domain\Exceptions\SizeTooBigException;

class File
{
    private const ALLOWED_SIZE = 20_000_000;
    private const ALLOWED_MIME_BY_EXTENSION = [
        'png' => ['image/png'],
        'jpg' => ['image/jpeg'],
        'jpeg' => ['image/jpeg'],
        'webp' => ['image/webp'],
        'pdf' => ['application/pdf'],
    ];

    private function __construct(
        private string $originalName,
        private string $storedName,
        private string $path,
        private string $extension,
        private int $size
    ) {}

    public static function create(
        string $originalName,
        string $storedName,
        string $path,
        string $extension,
        string $mimeType,
        int $size
    ): self {
        if (!self::isAllowedSize($size)) {
            throw new SizeTooBigException();
        }

        if (!self::isValidFileType($extension, $mimeType)) {
            throw new FileExtensionInvalidException();
        }

        return new self($originalName, $storedName, $path, $extension, $size);
    } 

    public function getOriginalName(): string
    {
        return $this->originalName;
    }

    public function getStoredName(): string
    {
        return $this->storedName;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getExtension(): string
    {
        return $this->extension;
    }

    public function getSize(): int
    {
        return $this->size;
    }

    private static function isAllowedSize(int $size): bool
    {
        return $size <= self::ALLOWED_SIZE ? true : false;
    }

    private static function isValidFileType(string $extension, string $mimeType): bool
    {
        $allowedMimes = self::ALLOWED_MIME_BY_EXTENSION[$extension] ?? null;

        if ($allowedMimes === null) {
            return false;
        }

        return in_array($mimeType, $allowedMimes, true);
    }
}
