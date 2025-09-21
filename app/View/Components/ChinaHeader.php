<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ChinaHeader extends Component
{
    public $title;
    public $route;

    /**
     * Create a new component instance.
     */
    public function __construct($title, $route)
    {
        $this->title = $title;
        $this->route = $route;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.ChinaHeader');
    }
}
