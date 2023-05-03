<?php

namespace zedsh\tower\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\Response;
use zedsh\tower\Facades\TowerAdmin;
use zedsh\tower\Fields\HiddenField;
use zedsh\tower\Forms\BaseForm;
use zedsh\tower\Lists\Columns\ActionsColumn;
use zedsh\tower\Lists\TableList;
use zedsh\tower\Templates\BaseTemplate;
use Illuminate\Support\Facades\Hash;
use zedsh\tower\Traits\ContainsFiles;
use function app;
use function back;
use function response;
use function route;

class BaseAdminResourceController extends Controller
{
    /** @var string|null classname of the Model which this resource operates on */
    protected ?string $modelClass = null;

    /** @var string|null classname of the Request which this resource uses for storing and updating */
    protected ?string $request = null;

    /** @var string|null name of the resource; should be the same as resource route name */
    protected ?string $resourceName = 'resource_name';

    /** @var string title displayed at index page */
    protected string $indexTitle = 'title';

    /** @var string title displayed at edit page */
    protected string $editTitle = 'title';

    /** @var string title displayed at create page */
    protected string $createTitle = 'title';

    /** @var int amount of items to display per page */
    protected int $itemsOnPage = 10;

    /** @var string classname of the list view used by the index page */
    protected string $listClass = TableList::class;

    /** @var string classname of the form used by the creation and editing pages */
    protected string $formClass = BaseForm::class;

    /**
     * Provides a map of routes used by the resource.
     * @param $model
     * @return array
     */
    protected function getRoutes($model): array
    {
        return [
            'store' => route($this->resourceName . '.store'),
            'editBack' => route($this->resourceName . '.index'),
            'createBack' => route($this->resourceName . '.index')
        ];
    }

    /**
     * Returns an array of fields (columns) used to display the index page.
     * @return array
     */
    protected function list(): array
    {
        return [];
    }

    /**
     * Returns an array of fields used to display a filter for the index page.
     * @return array
     */
    protected function filters(): array
    {
        return [];
    }

    /**
     * Returns an array of fields to display a form for creating and editing pages.
     * @param $model
     * @return array
     */
    protected function addEdit($model): array
    {
        return [];
    }

    /**
     * Returns an instance of [ActionsColumn] used to display actions block for each item at index list view.
     * @return ActionsColumn
     */
    protected function actions(): ActionsColumn
    {
        return (new ActionsColumn())
            ->setEditRoute($this->resourceName . '.edit')
            ->setDeleteRoute($this->resourceName . '.destroy')
            ->setDeleteOn()
            ->setDeleteWithForm()
            ->setEditOn()
            ->setRouteParams([
                $this->resourceName => function ($model) {
                    return $model->id;
                }
            ]);
    }

    /**
     * A hook to execute any actions before saving the Model.
     * @param $request
     * @param $model
     */
    protected function beforeSave($request, $model)
    {
        if ($request->has('password')) {
            $model->password = Hash::make($request->input('password'));
        }
    }

    /**
     * Renders the current admin page.
     * @param $renderable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    protected function render($renderable)
    {
        $projectTemplateClass = TowerAdmin::getProjectTemplateClass();
        if(!empty($projectTemplateClass)) {
            /** @var BaseTemplate|null $projectTemplateClass */
            return $projectTemplateClass::renderView($renderable);
        }

        return BaseTemplate::renderView($renderable);
    }

    /**
     * Returns a query Builder used to fetch items for the index page.
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function getListQuery(): \Illuminate\Database\Eloquent\Builder
    {
        /** @var Model $modelClass */
        $modelClass = $this->modelClass;
        return $modelClass::query()->orderBy('id','ASC');
    }

    /**
     * Renders the index page.
     * This should not be overridden unless you really need to change the way it looks/works.
     * If you just need to add fields (columns), filters or actions to the index page, please, opt to use [actions],
     * [list] and [filters] methods provided by the class.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
    {
        $actionColumn = $this->actions();
        $otherColumns = $this->list();
        $filters = $this->filters();

        /** @var TableList $list */
        $list = new $this->listClass($this->resourceName . '.list');

        $list->setTitle($this->indexTitle)
            ->setColumns([$actionColumn, ...$otherColumns])
            ->enableAdd()
            ->setFilters($filters)
            ->setAddPath(route($this->resourceName . '.create'))
            ->setQuery($this->getListQuery())
            ->enablePaginate()
            ->setItemsOnPage($this->itemsOnPage);

        return $this->render($list);
    }

    /**
     * Renders the creation page.
     * This should not be overridden unless you really need to change the way it looks/works.
     * Please, opt to use [addEdit] method provided by the class.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
    {
        $modelClass = $this->modelClass;
        $model = new $modelClass;

        $form = new $this->formClass($this->resourceName . '.form');

        $form
            ->setTitle($this->createTitle)
            ->setAction(route($this->resourceName . '.store'))
            ->setEncType('multipart/form-data')
            ->setMethod('POST')
            ->setBack($this->getRoutes($model)['createBack'])
            ->setModel($model)
            ->setFields($this->addEdit($model));

        return $this->render($form);
    }

    /**
     * Stores the new Model.
     * @return Response
     */
    public function store(): Response
    {
        $request = app($this->request);
        $data = $request->validated();

        $model = new $this->modelClass;
        $model->fill($data);

        $this->beforeSave($request, $model);
        $model->save();

        if(method_exists($model, 'syncFileFields')) {
            /** @var $model ContainsFiles */
            $model->syncFileFields($data);
        }

        return response()->redirectTo($this->getRoutes($model)['store']);
    }

    /**
     * Shows the details of a certain Model.
     * Not used by the admin panel. Implemented for compatibility with Laravel's Resource Controllers.
     * @param $id
     */
    public function show($id)
    {
    }

    /**
     * Renders the editing page.
     * This should not be overridden unless you really need to change the way it looks/works.
     * Please, opt to use [addEdit] method provided by the class.
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $modelClass = $this->modelClass;
        $model = $modelClass::query()->findOrFail($id);

        $form = new $this->formClass($this->resourceName . '.form');

        $form
            ->setTitle($this->editTitle)
            ->setAction(route($this->resourceName . '.update',[$this->resourceName => $id]))
            ->setEncType('multipart/form-data')
            ->setMethod('POST')
            ->setBack($this->getRoutes($model)['editBack'])
            ->setModel($model)
            ->setFields(
                array_merge($this->addEdit($model), [
                    (new HiddenField('id', ''))->setValue($id),
                    (new HiddenField('_method', ''))->setValue('PUT'),
                ]));

        return $this->render($form);
    }


    public function update($id)
    {
        $request = app($this->request);
        $data = $request->validated();

        $model = $this->modelClass::query()->findOrFail($id);
        $model->fill($data);

        $this->beforeSave($request, $model);
        $model->save();

        if(method_exists($model, 'syncFileFields')) {
            /** @var $model ContainsFiles */
            $model->syncFileFields($data);
        }

        return response()->redirectTo($this->getRoutes($model)['editBack']);
    }


    public function destroy($id)
    {
        $modelClass = $this->modelClass;
        $model = $modelClass::query()->findOrFail($id);
        $model->delete();
        $backRoute = $this->getRoutes($model)['editBack'] ?? null;
        return ($backRoute ? response()->redirectTo($backRoute) : back());
    }


}
