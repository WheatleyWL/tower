<?php

namespace zedsh\tower\Base;

class GlobalContext
{
    protected ?string $projectTemplateClass = null;

    public function setProjectTemplateClass(string $class): void
    {
        $this->projectTemplateClass = $class;
    }

    public function getProjectTemplateClass(): ?string
    {
        return $this->projectTemplateClass;
    }
}
