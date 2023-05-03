<?php

namespace zedsh\tower\Base;

use Closure;

class GlobalContext
{
    /** @var string|null a template classname used by the project */
    protected ?string $projectTemplateClass = null;

    /** @var array a buffer to store named templates for fields */
    protected array $viewTemplateBuffer = [];

    /**
     * @param string $class
     */
    public function setProjectTemplateClass(string $class): void
    {
        $this->projectTemplateClass = $class;
    }

    /**
     * @return string|null
     */
    public function getProjectTemplateClass(): ?string
    {
        return $this->projectTemplateClass;
    }

    /**
     * @param string $slotName
     * @param string $viewName
     */
    public function setNamedTemplate(string $slotName, string $viewName): void
    {
        $this->viewTemplateBuffer[$slotName] = $viewName;
    }

    /**
     * @return array
     */
    public function getNamedTemplates(): array
    {
        return $this->viewTemplateBuffer;
    }
}
