<?php


namespace zedsh\tower\Fields;

use zedsh\tower\Base\File;

class FileField extends BaseField
{
    protected bool $multiple = false;
    protected int $maxFileSize = 0;
    protected int $maxFileCount = 0;
    protected array $allowedFileTypes = [];

    protected $template = 'tower::fields.dropzone-file';

    public function setMultiple($value = true)
    {
        $this->multiple = $value;

        return $this;
    }

    public function getFormName()
    {
        $name = $this->getName();
        if ($this->multiple) {
            $name = $name . '[]';
        }

        return $name;
    }

    public function getMultiple()
    {
        return $this->multiple;
    }

    public function getModel()
    {
        return $this->model;
    }

    /**
     * Set maximum file size to be uploaded (in kilobytes).
     * @param int $maxFileSize
     * @return $this
     */
    public function setMaxFileSize(int $maxFileSize): self
    {
        $this->maxFileSize = $maxFileSize;
        return $this;
    }

    public function getMaxFileSize(): int
    {
        return $this->maxFileSize;
    }

    public function setMaxFileCount(int $maxFileCount): self
    {
        $this->maxFileCount = $maxFileCount;
        return $this;
    }

    public function getMaxFileCount(): int
    {
        if(!$this->getMultiple()) {
            return 1;
        }

        return $this->maxFileCount;
    }

    public function setAllowedFileTypes(array $fileTypes): self
    {
        $this->allowedFileTypes = $fileTypes;
        return $this;
    }

    public function getAllowedFileTypes(): array
    {
        return $this->allowedFileTypes;
    }
}
