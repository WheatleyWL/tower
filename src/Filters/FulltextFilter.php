<?php


namespace zedsh\tower\Filters;

class FulltextFilter extends BaseFilter
{
    protected function filter($query, $value)
    {
        $query->fulltextSearch($this->field, $value);
    }
}
