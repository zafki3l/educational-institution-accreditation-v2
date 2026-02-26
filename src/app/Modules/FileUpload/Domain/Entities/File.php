<?php

namespace App\Modules\FileUpload\Domain\Entities;

use App\Modules\FileUpload\Domain\Exceptions\FileExtensionInvalidException;
use App\Modules\FileUpload\Domain\Exceptions\InvalidIdException;
use App\Modules\FileUpload\Domain\Exceptions\SizeTooBigException;

class File
{
    private const ALLOWED_SIZE = 20_000_000;
    private const ALLOWED_EXTENSION = ['png', 'jpg', 'webp', 'pdf'];

    private function __construct(
        private string $id,
        private string $originalName,
        private string $storedName,
        private string $path,
        private string $extension,
        private int $size
    ) {}

    public static function create(
        string $id,
        string $originalName,
        string $storedName,
        string $path,
        string $extension,
        int $size
    ): self {
        if (!self::isValidUuidV4($id)) {
            throw new InvalidIdException();
        }

        if (!self::isAllowedSize($size)) {
            throw new SizeTooBigException();
        }

        if (!self::isValidExtension($extension)) {
            throw new FileExtensionInvalidException();
        }

        return new self($id, $originalName, $storedName, $path, $extension, $size);
    } 

    public function getId(): string
    {
        return $this->id;
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

    private static function isValidUuidV4(string $id): bool
    {
        return preg_match(
            '/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i',
            $id
        ) === 1;
    }

    private static function isAllowedSize(int $size): bool
    {
        return $size <= self::ALLOWED_SIZE ? true : false;
    }

    private static function isValidExtension(string $type): bool
    {
        return in_array($type, self::ALLOWED_EXTENSION);
    }
}
