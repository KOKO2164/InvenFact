<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ColumnFilter extends Component
{
    public $routes;
    public $columnSize;
    public $placeholder;
    public $filter;
    public $module;

    /**
     * Create a new component instance.
     */
    public function __construct($routes, $columnSize, $placeholder, $filter, $module)
    {
        $this->routes = $routes;
        $this->columnSize = $columnSize;
        $this->placeholder = $placeholder;
        $this->filter = $filter;
        $this->module = $module;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.column-filter');
    }
}
