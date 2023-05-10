<?php

namespace zedsh\tower\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use zedsh\tower\Facades\TowerAdmin;
use zedsh\tower\Templates\BaseTemplate;

class BaseAdminController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Renders the current admin page.
     * @param $renderable
     * @return Factory|View
     */
    protected function render($renderable): Factory|View
    {
        $projectTemplateClass = TowerAdmin::getProjectTemplateClass();
        if(!empty($projectTemplateClass)) {
            /** @var BaseTemplate|null $projectTemplateClass */
            return $projectTemplateClass::renderView($renderable);
        }

        return BaseTemplate::renderView($renderable);
    }
}
