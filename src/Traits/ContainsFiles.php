<?php

namespace zedsh\tower\Traits;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use zedsh\tower\Exceptions\ConfigurationException;
use zedsh\tower\Models\File;

trait ContainsFiles
{
    protected function getFileStorageMode(): FileStorageMode
    {
        return FileStorageMode::InCommonTable;
    }

    // NOTE(d.timofeev): classes cannot override trait properties hence we rely on property being defined
    // by the class itself, without providing a correct signature for it.
    // This probably should be revised later or towards more concrete way of telling implementors what to do.
    // protected array $fileFields = [];

    protected function getFileStorePath(): string
    {
        return Str::lower(str_replace('\\', '/', static::class));
    }

    protected function getFileStorageName(): string
    {
        return 'public';
    }

    public function storeFiles(array $fields)
    {
        if(!isset($this->fileFields) || !is_array($this->fileFields)) {
            $thisClass = self::class;
            throw new ConfigurationException("Class `$thisClass` uses ContainsFiles trait but did not "
                . "provide `\$fileFields` property! Check ContainsFiles definition for more info.");
        }

        foreach($this->fileFields as $fieldName) {
            if(!isset($fields[$fieldName])) {
                continue;
            }

            $files = $fields[$fieldName];
            if(!is_array($files)) {
                $files = [$files];
            }

            $this->storeFieldFiles($fieldName, $files);
        }
    }

    protected function storeFieldFiles(string $fieldName, array $files): void
    {
        $curValue = $this->{$fieldName} ?? [];

        $transients = [];
        foreach($files as $file) {
            if($file instanceof UploadedFile) {
                $transients[] = $this->storeUploadedFile($file);
            }
        }

    }

    protected function storeUploadedFile(UploadedFile $file): File
    {
        $storedPath = $file->store($this->getFileStorePath(), $this->getFileStorageName());

        $transientFile = new File();
        $transientFile->id = Str::uuid()->toString();
        $transientFile->path = $storedPath;
        $transientFile->name = $file->getClientOriginalName();
        $transientFile->extension = $file->getClientOriginalExtension();
        $transientFile->size = $file->getSize();
        $transientFile->mime = $file->getMimeType();

        return $transientFile;
    }
}
