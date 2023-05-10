<?php


namespace zedsh\tower\Forms;

use Illuminate\View\Factory;
use Illuminate\View\View;
use zedsh\tower\Fields\BaseField;
use zedsh\tower\Fields\FormFieldInterface;

/**
 * Class BaseForm
 * @package zedsh\tower\Forms
 * @property BaseField[] $fields
 */
class BaseForm
{
    protected string $name;
    protected object $model;
    protected string $title;
    protected string $action = '';
    protected string $back = '';
    protected string $template = 'tower::forms.base';
    /** @var FormFieldInterface[] */
    protected array $fields = [];
    protected string $encType = 'multipart/form-data';
    protected string $method = 'POST';

    /**
     * @param $name
     * @param FormFieldInterface[] $fields
     */
    public function __construct($name, array $fields = [])
    {
        $this->name = $name;
        $this->fields = $fields;
    }

    /**
     * Sets form fields.
     * @param FormFieldInterface[] $fields
     * @return $this
     */
    public function setFields(array $fields): self
    {
        $this->fields = $fields;
        return $this;
    }

    /**
     * Sets form action URL.
     * @param string $link
     * @return $this
     */
    public function setAction(string $link): self
    {
        $this->action = $link;
        return $this;
    }

    /**
     * Returns form action URL.
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * Sets form HTTP method.
     * @param string $method
     * @return $this
     */
    public function setMethod(string $method): self
    {
        $this->method = $method;
        return $this;
    }

    /**
     * Returns HTTP method used by the form.
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * Sets form encoding type.
     * @param string $encType
     * @return $this
     */
    public function setEncType(string $encType): self
    {
        $this->encType = $encType;
        return $this;
    }

    /**
     * Returns form encoding type.
     * @return string
     */
    public function getEncType(): string
    {
        return $this->encType;
    }

    /**
     * Sets back-URL for the 'CANCEL' button.
     * @param string $back
     * @return $this
     */
    public function setBack(string $back): self
    {
        $this->back = $back;
        return $this;
    }

    /**
     * Returns back-URL for the 'CANCEL' button.
     * @return string
     */
    public function getBack(): string
    {
        if (empty($this->back)) {
            return url()->previous();
        }

        return $this->back;
    }

    /**
     * Sets form title.
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Returns form title.
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Sets model object which will be passed into the fields to receive the data.
     * @param object $model
     * @return $this
     */
    public function setModel(object $model): self
    {
        $this->model = $model;
        return $this;
    }

    /**
     * Renders form and all of it's views.
     * @return View|Factory
     */
    public function render(): View|Factory
    {
        $content = '';
        foreach ($this->fields as $field) {
            if(method_exists($field, 'setModel')) {
                $field->setModel($this->model);
            }
            $content .= $field->render();
        }

        return view($this->template, ['content' => $content, 'form' => $this]);
    }
}
