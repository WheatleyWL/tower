<?php

namespace zedsh\tower\Fields\Default;

use zedsh\tower\Fields\FormFieldInterface;
use zedsh\tower\Traits\Fields\HasDataAttributes;

class HiddenField implements FormFieldInterface
{
    use HasDataAttributes;

    /**
     * @param string $name
     * @param string|null $value
     */
    public function __construct(string $name, ?string $value = null)
    {
        $this->setName($name);

        if($value !== null) {
            $this->setValue($value);
        }
    }

    /**
     * @return string
     */
    public function render(): string
    {
        $name = $this->getName();
        $value = $this->getValue();

        return "<input type='hidden' name='$name' value='$value'>";
    }
}
