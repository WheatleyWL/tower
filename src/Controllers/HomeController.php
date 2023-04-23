<?php

namespace zedsh\tower\Controllers;

use zedsh\tower\Exceptions\TowerInternalException;
use zedsh\tower\Facades\TowerAdmin;

class HomeController extends BaseAdminController
{
    public function index()
    {
        $templateClass = TowerAdmin::getProjectTemplateClass();

        if(empty($templateClass) || !class_exists($templateClass)) {
            return response()->view('tower::pages.home_dummy');
        }

        return $templateClass::renderView(view('tower::pages.home'));
    }
}
