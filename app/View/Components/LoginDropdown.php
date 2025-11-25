<?php

namespace App\View\Components;

use Illuminate\View\Component;

class LoginDropdown extends Component
{
    public $isAuthenticated;
    public $user;

    public function __construct()
    {
        $this->isAuthenticated = auth()->check();
        $this->user = auth()->user();
    }

    public function render()
    {
        return view('components.login-dropdown');
    }
}

