<?php

namespace zedsh\tower\Fields;

/**
 * A basic field which renders a view to represent itself.
 * This is **not** necessarily a *visible* field. Hidden fields also
 * use templates to properly fit into the form.
 */
class ViewFormField implements FormFieldInterface
{
    protected string $template;

    public function render(): string
    {
        return view($this->template, ['field' => $this])->render();
    }
}
