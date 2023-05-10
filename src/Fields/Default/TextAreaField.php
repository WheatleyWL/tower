<?php

namespace zedsh\tower\Fields\Default;

use zedsh\tower\Fields\BasicEditableFormField;

class TextAreaField extends BasicEditableFormField
{
    protected ?int $maxLength = null;
    protected string $template = 'tower::fields.textArea';

    /**
     * @param int|null $maxLength
     * @return $this
     */
    public function setMaxLength(?int $maxLength): self
    {
        $this->maxLength = $maxLength;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getMaxLength(): ?int
    {
        return $this->maxLength;
    }
}
