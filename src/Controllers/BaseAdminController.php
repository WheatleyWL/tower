<?php


namespace zedsh\tower\Controllers;

use Illuminate\Routing\Controller as BaseController;
use zedsh\tower\Templates\BaseTemplate;

class BaseAdminController extends BaseController
{
    protected $template;

    protected function getTemplate()
    {
        return (new BaseTemplate());
    }
}
