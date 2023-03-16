<?php

namespace App\Admin\Templates;

use zedsh\tower\Menu\BaseMenu;
use zedsh\tower\Menu\BaseMenuItem;
use zedsh\tower\Templates\BaseTemplate;

class ProjectTemplate extends BaseTemplate
{
    public function getMenu()
    {
        return new BaseMenu(
            [
                (new BaseMenuItem('Артисты', 'artist.list'))->setActiveWith('artist')->setInactiveWith('artist.type'),
            ]
        );
    }

}
