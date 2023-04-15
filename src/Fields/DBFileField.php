<?php


namespace zedsh\tower\Fields;

use zedsh\tower\Base\File;

class DBFileField extends BaseField
{
    protected $multiple = false;
    protected $template = 'tower::fields.dropzone-file';

    public function setMultiple($value = true)
    {
        $this->multiple = $value;

        return $this;
    }

    public function getFormName()
    {
        $name = $this->getName();
        if ($this->multiple) {
            $name = $name . '[]';
        }

        return $name;
    }

    public function getMultiple()
    {
        return $this->multiple;
    }

    public function getModel()
    {
        return $this->model;
    }

}
