<?php

namespace App\Modules\FileUpload\Application;

use App\Modules\FileUpload\Domain\Entities\File;
use App\Shared\Infrastructure\UuidGenerator;

final class UploadFileUseCase
{
    public function execute(array $file)
    {
        // Generate uuid v4 for file_id
        $id = UuidGenerator::v4();

        // Extract info
        $original_name = $file['name']; 

        $file_separator = explode('.', $file['name']);
        $extension = strtolower(end($file_separator));

        $size = $file['size'];

        // Generate stored name
        $stored_name = "{$id}.{$extension}";

        // Path 
        $path = $path = __DIR__ . '/../../../../public/assets/evidences';

        $entityFile = File::create(
            $id,
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