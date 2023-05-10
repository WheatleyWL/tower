<?php

namespace zedsh\tower\Fields\Default;

use zedsh\tower\Fields\BasicEditableFormField;

class PasswordField extends BasicEditableFormField
{
    protected string $template = 'tower::fields.password';
}
