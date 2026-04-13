<?php

namespace App\Modules\FileUpload\Application;

use App\Modules\FileUpload\Domain\Entities\File;
use App\Modules\FileUpload\Domain\Exceptions\FileUploadFailedException;
use App\Modules\FileUpload\Domain\Exceptions\FileUploadInvalidException;
use App\Shared\Infrastructure\Utils\UuidGenerator;

final class UploadFileUseCase
{
    public function execute(array $file, string $name = '')
    {
        if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
            throw new FileUploadInvalidException();
        }

        $tmpName = $file['tmp_name'] ?? '';
        if (!is_string($tmpName) || $tmpName === '' || !is_uploaded_file($tmpName)) {
            throw new FileUploadInvalidException();
        }

        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($tmpName);
        if (!is_string($mimeType) || $mimeType === '') {
            throw new FileUploadInvalidException();
        }

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
            $mimeType,
            $size
        );

        if (!move_uploaded_file($tmpName, $path . '/' . $entityFile->getStoredName())) {
            throw new FileUploadFailedException();
        }

        return $entityFile->getStoredName();
    }
}