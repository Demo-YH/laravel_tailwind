<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Header extends Component
{
    public $posts_count;
    /**
     * Create a new component instance.
     */
    public function __construct(int $postsCount = 0)
    {
        //
        $this->posts_count = $postsCount;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.header');
    }
}
