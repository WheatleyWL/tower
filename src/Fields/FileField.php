<?php


namespace zedsh\tower\Fields;

/**
 * File upload field.
 */
class FileField extends BaseField
{
    protected $template = 'tower::fields.dropzone_file';

    protected bool $multiple = false;
    protected int $maxFileSize = 0;
    protected int $maxFileCount = 0;
    protected array $allowedFileTypes = [];

    protected ?string $uploadUrl;
    protected ?string $editUrl;

    protected array $namedTemplateSlots = [
        'dropzone_file_template' => 'tower::fields.dropzone_file_template',
    ];

    public function __construct($name, $title = '')
    {
        parent::__construct($name, $title);

        $this->uploadUrl = route('tower_admin::file.store');
        $this->editUrl = route('tower_admin::file.update', ['file' => ':id']);
    }

    /**
     * Sets whether this field accepts multiple files.
     * @param bool $value
     * @return $this
     */
    public function setMultiple(bool $value = true): self
    {
        $this->multiple = $value;
        return $this;
    }

    /**
     * Returns whether this field accepts multiple files.
     * @return bool
     */
    public function getMultiple(): bool
    {
        return $this->multiple;
    }

    /**
     * Returns currently bound model. Returns empty model instance if field reside in 'Add' form.
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Sets max allowed file size per file. In kilobytes.
     * @param int $maxSize
     * @return $this
     */
    public function setMaxFileSize(int $maxSize): self
    {
        $this->maxFileSize = $maxSize;
        return $this;
    }

    /**
     * Returns max allowed file size per file.
     * @return int
     */
    public function getMaxFileSize(): int
    {
        return $this->maxFileSize;
    }

    /**
     * Sets max allowed file count.
     * If field doesn't accept multiple files this setting is ignored.
     * @param int $maxCount
     * @return $this
     */
    public function setMaxFileCount(int $maxCount): self
    {
        $this->maxFileCount = $maxCount;
        return $this;
    }

    /**
     * Returns max allowed file count.
     * Returns 1 if [setMultiple] was called with [false].
     * @return int
     */
    public function getMaxFileCount(): int
    {
        if(!$this->multiple) {
            return 1;
        }

        return $this->maxFileCount;
    }

    /**
     * Sets allowed file extensions to be uploaded.
     * @param array $types
     * @return $this
     */
    public function setAllowedFileTypes(array $types): self
    {
        $this->allowedFileTypes = $types;
        return $this;
    }

    /**
     * Returns allowed file types. Empty array signifies 'any files'.
     * @return array
     */
    public function getAllowedFileTypes(): array
    {
        return $this->allowedFileTypes;
    }

    /**
     * Sets route to be called by the uploader to save the file on the server.
     * Use this if you need to override default file saving behaviour.
     * @param string $uploadUrl
     * @return $this
     */
    public function setUploadUrl(string $uploadUrl): self
    {
        $this->uploadUrl = $uploadUrl;
        return $this;
    }

    /**
     * Returns route for the uploader to issue requests to.
     * @return string
     */
    public function getUploadUrl(): string
    {
        return $this->uploadUrl;
    }

    /**
     * Sets route to be called by the uploader to save changes to SEO data of the file.
     * Use this if you need to override default file editing behaviour.
     * Given route must contain `:id` template, like this:
     * ```php
     * route('tower_admin::file.update', ['file' => ':id'])
     * ```
     *
     * @param string $editUrl
     * @return $this
     */
    public function setEditUrl(string $editUrl): self
    {
        $this->editUrl = $editUrl;
        return $this;
    }

    /**
     * @return string
     */
    public function getEditUrl(): string
    {
        return $this->editUrl;
    }
}
