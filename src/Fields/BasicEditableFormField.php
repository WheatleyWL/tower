<?php

namespace zedsh\tower\Fields;

use zedsh\tower\Traits\Fields\HasDataAttributes;
use zedsh\tower\Traits\Fields\HasVisibleTitle;

/**
 * A simple editable form field.
 */
class BasicEditableFormField extends ViewFormField
{
    use HasDataAttributes, HasVisibleTitle;

    public function __construct(string $name, string $title)
    {
        $this->setName($name);
        $this->setTitle($title);
    }
}
