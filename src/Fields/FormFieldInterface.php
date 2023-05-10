<?php

namespace zedsh\tower\Fields;

/**
 * Base interface for all the fields understandable by Tower.
 */
interface FormFieldInterface
{
    /**
     * @return string
     */
    public function render(): string;
}
