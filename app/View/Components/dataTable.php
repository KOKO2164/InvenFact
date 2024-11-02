<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class dataTable extends Component
{
    public $info;
    public $titles;
    public $columns;
    public $routes;
    public $otherModels;

    /**
     * Create a new component instance.
     */
    public function __construct($info, $titles, $columns, $routes, $otherModels = [])
    {
        $this->info = $info;
        $this->titles = $titles;
        $this->columns = $columns;
        $this->routes = $routes;
        $this->otherModels = $otherModels;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.data-table');
    }
}
