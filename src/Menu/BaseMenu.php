<?php


namespace zedsh\tower\Menu;

/**
 * Class BaseMenu
 * @package zedsh\tower\Menu
 * @property BaseMenuItem $items
 */
class BaseMenu
{
    protected $template = 'tower::menu.menu';
    protected $items = [];

    public function __construct($items = [])
    {
        $this->items = $items;
    }

    public function setItems($items)
    {
        $this->items = $items;

        return $this;
    }

    public function getItems()
    {
        return $this->items;
    }

    public function render()
    {
        return view($this->template, ['menu' => $this])->render();
    }
}
