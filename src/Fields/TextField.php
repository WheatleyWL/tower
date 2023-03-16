<?php


namespace zedsh\tower\Fields;

class TextField extends BaseField
{
    protected $template = 'tower::fields.text';
    protected $slugFrom;

    public function setSlugFrom($name)
    {
        $this->slugFrom = $name;

        return $this;
    }

    public function getSlugFrom()
    {
        return $this->slugFrom;
    }
}
