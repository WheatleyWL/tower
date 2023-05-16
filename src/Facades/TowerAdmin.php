<?php

namespace zedsh\tower\Facades;

/**
 * @method static void setProjectTemplateClass(string $class)
 * @method static string getProjectTemplateClass()
 * @method static void setNamedTemplate(string $slotName, string $viewName)
 * @method static string[] getNamedTemplates()
 */
class TowerAdmin extends \Illuminate\Support\Facades\Facade
{
    protected static function getFacadeAccessor()
    {
        return 'tower::global_context';
    }
}
