<?php

namespace zedsh\tower\Fields\Default;

use zedsh\tower\Fields\BasicEditableFormField;
use zedsh\tower\Traits\Fields\HasNamedTemplateSlots;

/**
 * TODO: add description
 */
class StringListField extends BasicEditableFormField
{
    use HasNamedTemplateSlots;

    protected string $template = 'tower::fields.string_list';

    public function __construct(string $name, string $title)
    {
        parent::__construct($name, $title);

        $this->assignNamedTemplateSlots();
    }

    /**
     * @return string[]
     */
    protected function getNamedTemplateSlots(): array
    {
        return [
            'string_list_entry_template' => 'tower::fields.string_list_template',
        ];
    }

    /**
     * @return array
     */
    public function getEntries(): array
    {
        $values = $this->getValue() ?? [];
        if(is_string($values)) {
            return json_decode($values, true);
        }

        return $values;
    }
}
