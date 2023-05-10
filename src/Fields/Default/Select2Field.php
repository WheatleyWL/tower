<?php

namespace zedsh\tower\Fields\Default;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use zedsh\tower\Fields\BasicEditableFormField;

class Select2Field extends BasicEditableFormField
{
    protected string $template = 'tower::fields.select2';
    protected Collection $collection;
    protected string $id = 'id';
    protected string $showField = 'name';
    protected bool $multiple = false;
    protected string $relatedKey = 'id';
    protected string $ajaxUrl = '';

    /**
     * @param $key
     * @return $this
     */
    public function setRelatedKey($key): self
    {
        $this->relatedKey = $key;
        return $this;
    }

    /**
     * @return string
     */
    public function getRelatedKey(): string
    {
        return $this->relatedKey;
    }

    /**
     * @param $ajaxUrl
     * @return $this
     */
    public function setAjaxUrl($ajaxUrl): self
    {
        $this->ajaxUrl = $ajaxUrl;
        return $this;
    }

    /**
     * @return string
     */
    public function getAjaxUrl(): string
    {
        return $this->ajaxUrl;
    }

    /**
     * @param bool $value
     * @return $this
     */
    public function setMultiple(bool $value = true): self
    {
        $this->multiple = $value;
        return $this;
    }

    /**
     * @return bool
     */
    public function getMultiple(): bool
    {
        return $this->multiple;
    }

    /**
     * @param $collection
     * @return $this
     */
    public function setCollection($collection): self
    {
        $this->collection = $collection;
        return $this;
    }

    /**
     * @return Collection
     */
    public function getCollection(): Collection
    {
        return $this->collection;
    }

    /**
     * @param $id
     * @return $this
     */
    public function setId($id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param $fieldName
     * @return $this
     */
    public function setShowField($fieldName): self
    {
        $this->showField = $fieldName;
        return $this;
    }

    /**
     * @return string
     */
    public function getShowField(): string
    {
        return $this->showField;
    }

    /**
     * @return string
     */
    public function getFormName(): string
    {
        $name = $this->getName();
        if ($this->multiple) {
            $name = $name . '[]';
        }

        return $name;
    }

    /**
     * @param $id
     * @return bool
     */
    public function isSelected($id): bool
    {
        if ($this->multiple) {
            $value = $this->getValue();
            if ($value instanceof Collection) {
                return ($value->pluck($this->getRelatedKey())->contains($id));
            }

            if(is_array($value)) {
                return (in_array($id, $value));
            }

            return false;
        } else {
            $value = $this->getValue();
            if ($value instanceof Model) {
                return ($value->{$this->getRelatedKey()} === $id);
            } else {
                return ($value === $id);
            }
        }
    }
}
