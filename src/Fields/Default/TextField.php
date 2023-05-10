<?php

namespace zedsh\tower\Fields\Default;

use zedsh\tower\Fields\BasicEditableFormField;

class TextField extends BasicEditableFormField
{
    protected string $template = 'tower::fields.text';
    protected ?string $slugFrom = null;

    /**
     * @param $name
     * @return $this
     */
    public function setSlugFrom($name): self
    {
        $this->slugFrom = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSlugFrom(): ?string
    {
        return $this->slugFrom;
    }
}
