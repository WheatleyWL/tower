<?php

namespace zedsh\tower\Traits\Fields;

use zedsh\tower\Facades\TowerAdmin;

/**
 * Provides named template slots functionality to fields.
 */
trait HasNamedTemplateSlots
{
    /**
     * @return string[]
     */
    protected abstract function getNamedTemplateSlots(): array;

    /**
     * Assigns field-required named templates to be rendered later on.
     */
    protected function assignNamedTemplateSlots(): void
    {
        $slots = $this->getNamedTemplateSlots();
        foreach($slots as $slotName => $view) {
            TowerAdmin::setNamedTemplate($slotName, $view);
        }
    }
}
