<?php

namespace zedsh\tower\Fields\Default;

use zedsh\tower\Fields\BasicEditableFormField;

/**
 * A checkbox-style boolean field.
 */
class BooleanField extends BasicEditableFormField
{
    protected string $template = 'tower::fields.boolean';
}
