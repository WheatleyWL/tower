<?php

namespace zedsh\tower\Fields\Default;

use Carbon\Carbon;
use zedsh\tower\Fields\BasicEditableFormField;

/**
 * A simple date selector field.
 */
class DateField extends BasicEditableFormField
{
    protected string $template = 'tower::fields.date';
    protected string $dateFormat = 'd.m.Y';

    /**
     * @param $format
     * @return $this
     */
    public function setDateFormat($format): self
    {
        $this->dateFormat = $format;
        return $this;
    }

    /**
     * @return string
     */
    public function getDateFormat(): string
    {
        return $this->dateFormat;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        $date = parent::getValue();
        if (empty($date) || !($date instanceof Carbon)) {
            $date = new Carbon();
        }

        return $date->format($this->getDateFormat());
    }
}
