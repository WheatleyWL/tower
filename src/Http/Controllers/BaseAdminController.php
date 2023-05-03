<?php


namespace zedsh\tower\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use zedsh\tower\Templates\BaseTemplate;

class BaseAdminController extends BaseController
{
    protected BaseTemplate $template;

    protected function getTemplate()
    {
        return (new BaseTemplate());
    }
}
