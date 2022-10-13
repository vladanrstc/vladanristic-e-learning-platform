<?php

namespace App\StorageManagement;

use App\DTOs\FileDTO;
use App\Enums\Messages;
use App\Exceptions\FileStorageException;
use Illuminate\Support\Facades\Storage;

class StorageHelper
{

    /**
     * @param  string  $disk
     * @param  FileDTO  $fileDTO
     * @param  string  $module
     * @param  string  $folder
     * @return string
     * @throws FileStorageException
     */
    public static function storeFile(string $disk, FileDTO $fileDTO, string $module, string $folder): string
    {
        $fullPathToFile = strtolower($module).DIRECTORY_SEPARATOR.$folder.$fileDTO->getFullFileName();
        if (Storage::disk($disk)->put($fullPathToFile, $fileDTO->getFileContents())) {
            return $fullPathToFile;
        }
        throw new FileStorageException(Messages::FAILED_TO_WRITE_TO_FILE->value);
    }

}
