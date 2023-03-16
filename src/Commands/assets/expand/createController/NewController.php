<?php

namespace App\Http\Controllers\Admin;

use App\Models\News;
use App\Http\Requests\Admin\TagStoreUpdateRequest;
use zedsh\tower\Fields\TextField;
use zedsh\tower\Lists\Columns\TextColumn;

class NewController extends AdminResourceController
{
    protected $modelClass = null;
    protected $request = null;
    protected $resourceName = 'resource_name';

    protected $indexTitle = 'Список';
    protected $editTitle = 'Редактирование';
    protected $createTitle = 'Создание';

    protected function addEdit($model)
    {
        return [];
    }

    protected function list(): array
    {
        return [ (new TextColumn('id', '#'))->setWidth(50), ];
    }
}
