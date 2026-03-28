<?php

namespace App\Modules\FileUpload\Application;

use App\Modules\FileUpload\Domain\Entities\File;
use App\Shared\Infrastructure\Utils\UuidGenerator;

final class UploadFileUseCase
{
    public function execute(array $file, string $name = '')
    {
        // Extract info
        $original_name = $file['name']; 

        $file_separator = explode('.', $file['name']);
        $extension = strtolower(end($file_separator));

        $size = $file['size'];

        // Generate stored name
        $safeName = str_replace('.', '_', $name);

        $stored_name = ($name === '') 
            ? UuidGenerator::v4() . ".{$extension}"
            : "{$safeName}_" . date("YmdHis") . ".{$extension}";

        // Path 
        $path = __DIR__ . '/../../../../public/assets/evidences';

        if (!is_dir($path)) {
            mkdir($path, 0775, true);
        }

        $entityFile = File::create(
            $original_name,
            $stored_name,
            $path,
            $extension,
            $size
        );

        move_uploaded_file($file['tmp_name'], $path . '/' . $entityFile->getStoredName());

        return $entityFile->getStoredName();
    }
}