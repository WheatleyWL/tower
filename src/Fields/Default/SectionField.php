<?php

namespace zedsh\tower\Fields\Default;

use zedsh\tower\Fields\FormFieldInterface;
use zedsh\tower\Fields\ViewFormField;
use zedsh\tower\Traits\Fields\HasDataAttributes;
use zedsh\tower\Traits\Fields\HasVisibleTitle;

class SectionField extends ViewFormField
{
    use HasVisibleTitle, HasDataAttributes;

    protected string $template = 'tower::fields.section';

    /**
     * @param $title
     * @param FormFieldInterface[] $fields
     */
    public function __construct($title, protected array $fields = [])
    {
        $this->setTitle($title);
    }

    /**
     * @return string
     */
    public function renderNested(): string
    {
        $rendered = [];
        foreach($this->fields as $field) {
            if(method_exists($field, 'setModel')) {
                $field->setModel($this->getModel());
            }

            $rendered[] = $field->render();
        }

        return implode('', $rendered);
    }
}
