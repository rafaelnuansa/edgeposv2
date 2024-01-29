<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Header extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {

        $currentTime = now();
        $user = auth()->user();
        $selectedBranch = $user->active_branch_id;
        $branch = encrypt($selectedBranch);
        $branches = $user->branches;


        return view('components.header', compact('branches', 'selectedBranch'));
    }
}
