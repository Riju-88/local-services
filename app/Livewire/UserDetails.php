<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\User;

class UserDetails extends Component
{
    public User $user;

    public function mount(User $user): void
    {
        $this->user = $user;
    }

    public function render()
    {
        return view('livewire.user-details');
    }
}
