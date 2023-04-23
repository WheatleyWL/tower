<?php

namespace zedsh\tower\Facades;

/**
 * @method static void setProjectTemplateClass(string $class)
 * @method static string getProjectTemplateClass()
 */
class TowerAdmin extends \Illuminate\Support\Facades\Facade
{
    protected static function getFacadeAccessor()
    {
        return 'tower_admin::global_context';
    }
}
