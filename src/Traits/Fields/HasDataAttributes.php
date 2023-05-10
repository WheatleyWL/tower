<?php

namespace zedsh\tower\Traits\Fields;

use Illuminate\Support\Facades\Request;

/**
 * Provides basic accessors required to display and store data with the field.
 */
trait HasDataAttributes
{
    protected string $name;
    protected mixed $value;
    protected object $model;

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setValue($value): self
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValue(): mixed
    {
        $oldValue = Request::old($this->name);
        return ($oldValue !== null) ? $oldValue : ($this->value ?? $this->model?->{$this->name});
    }

    /**
     * @param object $model
     * @return $this
     */
    public function setModel(object $model): self
    {
        $this->model = $model;
        return $this;
    }

    /**
     * @return object
     */
    public function getModel(): object
    {
        return $this->model;
    }
}
