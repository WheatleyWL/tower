<?php

namespace zedsh\tower\Traits\Fields;

/**
 * Provides title attribute accessors for visible fields.
 */
trait HasVisibleTitle
{
    protected string $title;

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }
}
