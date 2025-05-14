<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;

class Test extends Component
{
    public $users;

    public function mount()
    {
         $this->users = User::whereHas('roles')->get();;
    }
    public function render()
    {
        return view('livewire.test');
    }
}
